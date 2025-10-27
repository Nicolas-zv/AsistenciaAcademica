<?php

namespace App\Http\Controllers;

use App\Models\GrupoMateria;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HorarioController extends Controller
{
    // Define los días de la semana
    private $dias = [
        1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 
        5 => 'Viernes', 6 => 'Sábado', 0 => 'Domingo'
    ];

    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        // Carga la relación grupoMateria y sus subrelaciones para mostrar la información completa
        $horarios = Horario::with([
            'grupoMateria.materia', 
            'grupoMateria.grupo', 
            'grupoMateria.gestion', 
            'grupoMateria.aula'
        ])
        ->orderBy('dia')
        ->orderBy('hora_inicio')
        ->get();

        return view('horarios.index', compact('horarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $dias = $this->dias;
        // Carga las combinaciones de Grupo-Materia (sigla - grupo - gestión)
        $grupoMaterias = GrupoMateria::with(['materia', 'grupo', 'gestion'])
            ->get()
            ->map(function ($gm) {
                return [
                    'id' => $gm->id,
                    'nombre_completo' => "{$gm->materia->sigla} - {$gm->grupo->nombre} ({$gm->gestion->año} {$gm->gestion->semestre})",
                ];
            })
            ->sortBy('nombre_completo');
            
        return view('horarios.create', compact('grupoMaterias', 'dias'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'grupo_materia_id' => 'required|exists:grupo_materia,id',
            'dia' => ['required', 'integer', Rule::in(array_keys($this->dias))],
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'modalidad' => ['nullable', 'string', Rule::in(['Presencial', 'Virtual', 'Híbrido'])],
            'estado' => ['required', 'string', Rule::in(['programado', 'vigente', 'cancelado'])],
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')
                         ->with('success', 'El horario ha sido creado exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Horario $horario)
    {
        return view('horarios.show', compact('horario'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Horario $horario)
    {
        $dias = $this->dias;
        $grupoMaterias = GrupoMateria::with(['materia', 'grupo', 'gestion'])
            ->get()
            ->map(function ($gm) {
                return [
                    'id' => $gm->id,
                    'nombre_completo' => "{$gm->materia->sigla} - {$gm->grupo->nombre} ({$gm->gestion->año} {$gm->gestion->semestre})",
                ];
            })
            ->sortBy('nombre_completo');
            
        return view('horarios.edit', compact('horario', 'grupoMaterias', 'dias'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'grupo_materia_id' => 'required|exists:grupo_materia,id',
            'dia' => ['required', 'integer', Rule::in(array_keys($this->dias))],
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'modalidad' => ['nullable', 'string', Rule::in(['Presencial', 'Virtual', 'Híbrido'])],
            'estado' => ['required', 'string', Rule::in(['programado', 'vigente', 'cancelado'])],
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')
                         ->with('success', 'El horario ha sido actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')
                         ->with('success', 'El horario para ' . $horario->grupoMateria->materia->sigla . ' ha sido eliminado correctamente.');
    }
}