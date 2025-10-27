<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $modulos = Modulo::orderBy('nombre')->get();
        return view('modulos.index', compact('modulos'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('modulos.create');
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:50|unique:modulos,codigo',
        ]);

        Modulo::create($request->all());

        return redirect()->route('modulos.index')
                         ->with('success', 'El módulo ' . $request->nombre . ' ha sido creado exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Modulo $modulo)
    {
        return view('modulos.show', compact('modulo'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Modulo $modulo)
    {
        return view('modulos.edit', compact('modulo'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Modulo $modulo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // El código debe ser único, excluyendo el módulo actual
            'codigo' => 'nullable|string|max:50|unique:modulos,codigo,' . $modulo->id,
        ]);

        $modulo->update($request->all());

        return redirect()->route('modulos.index')
                         ->with('success', 'El módulo ' . $modulo->nombre . ' ha sido actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Modulo $modulo)
    {
        $nombre = $modulo->nombre;
        $modulo->delete();

        return redirect()->route('modulos.index')
                         ->with('success', 'El módulo ' . $nombre . ' ha sido eliminado correctamente.');
    }
}