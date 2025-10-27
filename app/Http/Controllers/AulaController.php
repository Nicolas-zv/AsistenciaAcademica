<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AulaController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        // Carga la relación 'modulo' para evitar el problema N+1
        $aulas = Aula::with('modulo')->orderBy('numero')->get(); 
        return view('aulas.index', compact('aulas'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $modulos = Modulo::orderBy('nombre')->get();
        return view('aulas.create', compact('modulos'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:50',
            'tipo' => ['nullable', 'string', Rule::in(['Aula Teórica', 'Laboratorio', 'Aula Taller', 'Auditorio', 'Oficina'])],
            'capacidad' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string|max:255',
            'modulo_id' => 'nullable|exists:modulos,id', // Verifica que el módulo exista
        ]);

        Aula::create($request->all());

        return redirect()->route('aulas.index')
                         ->with('success', 'El aula N° ' . $request->numero . ' ha sido creada exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Aula $aula)
    {
        return view('aulas.show', compact('aula'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Aula $aula)
    {
        $modulos = Modulo::orderBy('nombre')->get();
        return view('aulas.edit', compact('aula', 'modulos'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'numero' => 'required|string|max:50',
            'tipo' => ['nullable', 'string', Rule::in(['Aula Teórica', 'Laboratorio', 'Aula Taller', 'Auditorio', 'Oficina'])],
            'capacidad' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string|max:255',
            'modulo_id' => 'nullable|exists:modulos,id',
        ]);

        $aula->update($request->all());

        return redirect()->route('aulas.index')
                         ->with('success', 'El aula N° ' . $aula->numero . ' ha sido actualizada exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Aula $aula)
    {
        $numero = $aula->numero;
        $aula->delete();

        return redirect()->route('aulas.index')
                         ->with('success', 'El aula N° ' . $numero . ' ha sido eliminada correctamente.');
    }
}