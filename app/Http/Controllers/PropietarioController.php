<?php

// app/Http/Controllers/PropietarioController.php
namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropietarioController extends Controller
{
    public function index()
    {
        $propietarios = Propietario::with('tiendas')->get();
        return response()->json($propietarios);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('fotos_propietarios', $fileName, 'public');
            $validated['foto'] = $fileName;
            $validated['foto_url'] = Storage::url($path);
        }

        $propietario = Propietario::create($validated);
        return response()->json($propietario, 201);
    }

    public function show($id)
    {
        $propietario = Propietario::with('tiendas')->findOrFail($id);
        return response()->json($propietario);
    }

    public function update(Request $request, $id)
    {
        $propietario = Propietario::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($propietario->foto) {
                Storage::delete('public/fotos_propietarios/' . $propietario->foto);
            }

            $file = $request->file('foto');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('fotos_propietarios', $fileName, 'public');
            $validated['foto'] = $fileName;
            $validated['foto_url'] = Storage::url($path);
        }

        $propietario->update($validated);
        return response()->json($propietario);
    }

    public function destroy($id)
    {
        $propietario = Propietario::findOrFail($id);

        // Eliminar foto asociada si existe
        if ($propietario->foto) {
            Storage::delete('public/fotos_propietarios/' . $propietario->foto);
        }

        $propietario->delete();
        return response()->json(['message' => 'Propietario eliminado correctamente']);
    }
}