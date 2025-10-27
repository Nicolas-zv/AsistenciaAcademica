<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Gestion;
use App\Models\Grupo;
use App\Models\GrupoMateria;
use App\Models\Materia;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GrupoMateriaController extends Controller
{
    // Carga todos los catálogos necesarios para los formularios
    private function loadCatalogs()
    {
        return [
            'materias' => Materia::orderBy('sigla')->get(),
            'grupos' => Grupo::orderBy('nombre')->get(),
            'gestiones' => Gestion::orderBy('año', 'desc')->orderBy('semestre', 'desc')->get(),
            'aulas' => Aula::with('modulo')->orderBy('numero')->get(),
            'modulos' => Modulo::orderBy('nombre')->get(),
        ];
    }

    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        // Carga las relaciones principales para la tabla
        $grupoMaterias = GrupoMateria::with(['materia', 'grupo', 'gestion', 'aula', 'modulo'])
            ->orderBy('gestion_id', 'desc')
            ->get();

        return view('grupo_materia.index', compact('grupoMaterias'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $catalogs = $this->loadCatalogs();
        return view('grupo_materia.create', $catalogs);
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'grupo_id' => 'required|exists:grupos,id',
            'gestion_id' => 'required|exists:gestion,id',
            'aula_id' => 'nullable|exists:aulas,id',
            'modulo_id' => 'nullable|exists:modulos,id',
            'turno' => ['nullable', 'string', Rule::in(['Mañana', 'Tarde', 'Noche'])],
            'cupo' => 'nullable|integer|min:1',
            'estado' => ['required', 'string', Rule::in(['activo', 'inactivo', 'cerrado'])],
            // Regla de unicidad combinada
            'materia_id' => Rule::unique('grupo_materia')->where(function ($query) use ($request) {
                return $query->where('grupo_id', $request->grupo_id)
                             ->where('gestion_id', $request->gestion_id);
            }),
        ], [
            'materia_id.unique' => 'Ya existe una combinación de Materia, Grupo y Gestión con estos valores.',
        ]);

        GrupoMateria::create($request->all());

        return redirect()->route('grupo_materia.index')
                         ->with('success', 'El Grupo-Materia ha sido registrado exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(GrupoMateria $grupoMateria)
    {
        return view('grupo_materia.show', compact('grupoMateria'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(GrupoMateria $grupoMateria)
    {
        // Carga las dependencias necesarias
        $catalogs = $this->loadCatalogs(); // O el método que uses para cargar Materias, Grupos, Aulas, etc.

        // ¡Esta línea debe ejecutarse y compactar la variable $grupoMateria!
        return view('grupo_materia.edit', array_merge(compact('grupoMateria'), $catalogs)); 
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, GrupoMateria $grupoMateria)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'grupo_id' => 'required|exists:grupos,id',
            'gestion_id' => 'required|exists:gestion,id',
            'aula_id' => 'nullable|exists:aulas,id',
            'modulo_id' => 'nullable|exists:modulos,id',
            'turno' => ['nullable', 'string', Rule::in(['Mañana', 'Tarde', 'Noche'])],
            'cupo' => 'nullable|integer|min:1',
            'estado' => ['required', 'string', Rule::in(['activo', 'inactivo', 'cerrado'])],
            // Regla de unicidad combinada, excluyendo el registro actual
            'materia_id' => Rule::unique('grupo_materia')->ignore($grupoMateria->id)->where(function ($query) use ($request) {
                return $query->where('grupo_id', $request->grupo_id)
                             ->where('gestion_id', $request->gestion_id);
            }),
        ], [
            'materia_id.unique' => 'Ya existe una combinación de Materia, Grupo y Gestión con estos valores.',
        ]);

        $grupoMateria->update($request->all());

        return redirect()->route('grupo_materia.index')
                         ->with('success', 'El Grupo-Materia ha sido actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(GrupoMateria $grupoMateria)
    {
        $materiaNombre = $grupoMateria->materia->sigla ?? 'Materia';
        $grupoNombre = $grupoMateria->grupo->nombre ?? 'Grupo';
        $gestion = $grupoMateria->gestion->año ?? 'Gestión';
        
        $grupoMateria->delete();

        return redirect()->route('grupo_materia.index')
                         ->with('success', "La combinación {$materiaNombre}-{$grupoNombre} ({$gestion}) ha sido eliminada.");
    }
}