<?php

// app/Http/Controllers/TiendaController.php
namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TiendaController extends Controller
{
    public function index()
    {
        $tiendas = Tienda::with(['propietario', 'permisos'])->get();
        return response()->json($tiendas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'propietario_id' => 'required|uuid|exists:propietarios,id',
            'direccion_tienda' => 'required|string|max:255',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('fotos_tiendas', $fileName, 'public');
            $validated['foto'] = $fileName;
            $validated['foto_url'] = Storage::url($path);
        }

        $tienda = Tienda::create($validated);
        return response()->json($tienda, 201);
    }

    public function show($id)
    {
        $tienda = Tienda::with(['propietario', 'permisos'])->findOrFail($id);
        return response()->json($tienda);
    }

    public function update(Request $request, $id)
    {
        $tienda = Tienda::findOrFail($id);

        $validated = $request->validate([
            'propietario_id' => 'sometimes|uuid|exists:propietarios,id',
            'direccion_tienda' => 'sometimes|string|max:255',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($tienda->foto) {
                Storage::delete('public/fotos_tiendas/' . $tienda->foto);
            }

            $file = $request->file('foto');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('fotos_tiendas', $fileName, 'public');
            $validated['foto'] = $fileName;
            $validated['foto_url'] = Storage::url($path);
        }

        $tienda->update($validated);
        return response()->json($tienda);
    }

    public function destroy($id)
    {
        $tienda = Tienda::findOrFail($id);

        // Eliminar foto asociada si existe
        if ($tienda->foto) {
            Storage::delete('public/fotos_tiendas/' . $tienda->foto);
        }

        $tienda->delete();
        return response()->json(['message' => 'Tienda eliminada correctamente']);
    }
}