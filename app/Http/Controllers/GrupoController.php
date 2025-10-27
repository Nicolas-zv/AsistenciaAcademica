<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $grupos = Grupo::orderBy('nombre')->get();
        return view('grupos.index', compact('grupos'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('grupos.create');
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:grupos,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.index')
                         ->with('success', 'El grupo ' . $request->nombre . ' ha sido creado exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Grupo $grupo)
    {
        return view('grupos.show', compact('grupo'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:grupos,nombre,' . $grupo->id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $grupo->update($request->all());

        return redirect()->route('grupos.index')
                         ->with('success', 'El grupo ' . $grupo->nombre . ' ha sido actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Grupo $grupo)
    {
        $nombre = $grupo->nombre;
        $grupo->delete();

        return redirect()->route('grupos.index')
                         ->with('success', 'El grupo ' . $nombre . ' ha sido eliminado correctamente.');
    }
}