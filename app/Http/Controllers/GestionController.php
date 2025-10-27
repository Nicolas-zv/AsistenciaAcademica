<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GestionController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $gestiones = Gestion::orderBy('año', 'desc')->orderBy('semestre', 'desc')->get();
        return view('gestion.index', compact('gestiones'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('gestion.create');
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'año' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'semestre' => ['nullable', 'string', 'max:50', Rule::in(['I', 'II', 'Verano'])],
            'descripcion' => 'nullable|string|max:1000',
            'estado' => ['required', 'string', Rule::in([Gestion::ESTADO_ACTIVA, Gestion::ESTADO_INACTIVA])],
        ]);

        // Lógica de validación: Si intenta crearla como 'activa', desactiva cualquier otra.
        if ($request->estado === Gestion::ESTADO_ACTIVA) {
            Gestion::where('estado', Gestion::ESTADO_ACTIVA)->update(['estado' => Gestion::ESTADO_INACTIVA]);
        }

        $gestion = Gestion::create($request->all());

        return redirect()->route('gestion.index')
                         ->with('success', 'La gestión ' . $gestion->año . '-' . $gestion->semestre . ' ha sido creada exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Gestion $gestion)
    {
        return view('gestion.show', compact('gestion'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Gestion $gestion)
    {
        return view('gestion.edit', compact('gestion'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Gestion $gestion)
    {
        $request->validate([
            'año' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'semestre' => ['nullable', 'string', 'max:50', Rule::in(['I', 'II', 'Verano'])],
            'descripcion' => 'nullable|string|max:1000',
            'estado' => ['required', 'string', Rule::in([Gestion::ESTADO_ACTIVA, Gestion::ESTADO_INACTIVA])],
        ]);

        // Lógica de validación: Si intenta actualizarla a 'activa', desactiva cualquier otra.
        if ($request->estado === Gestion::ESTADO_ACTIVA) {
            Gestion::where('estado', Gestion::ESTADO_ACTIVA)
                   ->where('id', '!=', $gestion->id)
                   ->update(['estado' => Gestion::ESTADO_INACTIVA]);
        }

        $gestion->update($request->all());

        return redirect()->route('gestion.index')
                         ->with('success', 'La gestión ha sido actualizada exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Gestion $gestion)
    {
        $nombre = $gestion->año . '-' . $gestion->semestre;
        $gestion->delete();

        return redirect()->route('gestion.index')
                         ->with('success', 'La gestión ' . $nombre . ' ha sido eliminada correctamente.');
    }
}