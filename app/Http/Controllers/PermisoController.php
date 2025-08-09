<?php

// app/Http/Controllers/PermisoController.php
namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::with('tienda')->get();
        return response()->json($permisos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tienda_id' => 'required|uuid|exists:tiendas,id',
            'fecha_permiso' => 'required|date',
            'certificado_bomberos' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'soporte_acripol' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($request->hasFile('certificado_bomberos')) {
            $file = $request->file('certificado_bomberos');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('certificados', $fileName, 'public');
            $validated['certificado_bomberos'] = $fileName;
        }

        if ($request->hasFile('soporte_acripol')) {
            $file = $request->file('soporte_acripol');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('soportes', $fileName, 'public');
            $validated['soporte_acripol'] = $fileName;
        }

        $permiso = Permiso::create($validated);
        return response()->json($permiso, 201);
    }

    public function show($id)
    {
        $permiso = Permiso::with('tienda')->findOrFail($id);
        return response()->json($permiso);
    }

    public function update(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);

        $validated = $request->validate([
            'tienda_id' => 'sometimes|uuid|exists:tiendas,id',
            'fecha_permiso' => 'sometimes|date',
            'certificado_bomberos' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'soporte_acripol' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Manejo de certificado_bomberos
        if ($request->hasFile('certificado_bomberos')) {
            // Eliminar archivo anterior si existe
            if ($permiso->certificado_bomberos) {
                Storage::delete('public/certificados/' . $permiso->certificado_bomberos);
            }

            $file = $request->file('certificado_bomberos');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('certificados', $fileName, 'public');
            $validated['certificado_bomberos'] = $fileName;
        }

        // Manejo de soporte_acripol
        if ($request->hasFile('soporte_acripol')) {
            // Eliminar archivo anterior si existe
            if ($permiso->soporte_acripol) {
                Storage::delete('public/soportes/' . $permiso->soporte_acripol);
            }

            $file = $request->file('soporte_acripol');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('soportes', $fileName, 'public');
            $validated['soporte_acripol'] = $fileName;
        }

        $permiso->update($validated);
        return response()->json($permiso);
    }

    public function destroy($id)
    {
        $permiso = Permiso::findOrFail($id);

        // Eliminar archivos asociados si existen
        if ($permiso->certificado_bomberos) {
            Storage::delete('public/certificados/' . $permiso->certificado_bomberos);
        }

        if ($permiso->soporte_acripol) {
            Storage::delete('public/soportes/' . $permiso->soporte_acripol);
        }

        $permiso->delete();
        return response()->json(['message' => 'Permiso eliminado correctamente']);
    }
}