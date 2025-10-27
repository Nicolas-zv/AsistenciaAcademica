<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::orderBy('id')->paginate(10);
        return view('permisos.index', compact('permisos'));
    }

    public function create()
    {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:permisos,nombre|max:255',
            'descripcion' => 'nullable|max:255',
        ]);

        Permiso::create($request->all());

        return redirect()->route('permisos.index')
                         ->with('success', 'Permiso creado exitosamente.');
    }

    public function show(Permiso $permiso)
    {
        return view('permisos.show', compact('permiso'));
    }

    public function edit(Permiso $permiso)
    {
        return view('permisos.edit', compact('permiso'));
    }

    public function update(Request $request, Permiso $permiso)
    {
        $request->validate([
            'nombre' => 'required|unique:permisos,nombre,' . $permiso->id . '|max:255',
            'descripcion' => 'nullable|max:255',
        ]);

        $permiso->update($request->all());

        return redirect()->route('permisos.index')
                         ->with('success', 'Permiso actualizado exitosamente.');
    }

    public function destroy(Permiso $permiso)
    {
        // En una aplicación real, aquí deberías verificar si algún rol usa este permiso antes de eliminar.
        $permiso->delete();

        return redirect()->route('permisos.index')
                         ->with('success', 'Permiso eliminado exitosamente.');
    }
}