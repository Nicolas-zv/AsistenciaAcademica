<?php

namespace App\Http\Controllers;

use App\Models\GrupoMateria;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HorarioController extends Controller
{

    private $dias = [
        1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 
        5 => 'Viernes', 6 => 'Sábado', 0 => 'Domingo'
    ];

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
        $validatedData = $request->validate([
            'grupo_materia_id' => 'required|exists:grupo_materia,id',
            'dia' => ['required', 'integer', Rule::in(array_keys($this->dias))],
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'modalidad' => ['nullable', 'string', Rule::in(['Presencial', 'Virtual', 'Híbrido'])],
            'estado' => ['required', 'string', Rule::in(['programado', 'vigente', 'cancelado'])],
        ]);

        // 1. Obtener los IDs de Aula y Docente del GrupoMateria seleccionado
        $grupoMateria = GrupoMateria::with(['aula', 'docente'])->findOrFail($validatedData['grupo_materia_id']);
        
        $aulaId = $grupoMateria->aula_id;
        $docenteId = $grupoMateria->docente_id;
        
        // 2. Ejecutar la validación de colisión de Aula y Docente
        $this->checkCollision($validatedData['dia'], $validatedData['hora_inicio'], $validatedData['hora_fin'], $aulaId, $docenteId);

        // Si no hay colisión, crea el horario
        Horario::create($validatedData);

        return redirect()->route('horarios.index')
                         ->with('success', 'El horario ha sido creado exitosamente.');
    }

    public function show(Horario $horario)
    {
        return view('horarios.show', compact('horario'));
    }

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

    public function update(Request $request, Horario $horario)
    {
        $validatedData = $request->validate([
            'grupo_materia_id' => 'required|exists:grupo_materia,id',
            'dia' => ['required', 'integer', Rule::in(array_keys($this->dias))],
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'modalidad' => ['nullable', 'string', Rule::in(['Presencial', 'Virtual', 'Híbrido'])],
            'estado' => ['required', 'string', Rule::in(['programado', 'vigente', 'cancelado'])],
        ]);

        // 1. Obtener los IDs de Aula y Docente del GrupoMateria seleccionado
        $grupoMateria = GrupoMateria::with(['aula', 'docente'])->findOrFail($validatedData['grupo_materia_id']);
        
        $aulaId = $grupoMateria->aula_id;
        $docenteId = $grupoMateria->docente_id;
        
        // 2. Ejecutar la validación de colisión de Aula y Docente, excluyendo el ID actual
        $this->checkCollision($validatedData['dia'], $validatedData['hora_inicio'], $validatedData['hora_fin'], $aulaId, $docenteId, $horario->id);
        
        // Si no hay colisión, actualiza el horario
        $horario->update($validatedData);

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
    /**
     * Verifica si existe una colisión de horario (aula o docente)
     */
    private function checkCollision($dia, $inicio, $fin, $aulaId = null, $docenteId = null, $exceptId = null)
    {
        // 1. Colisión de Aula (El mismo aula está ocupada a esa hora)
        if ($aulaId) {
            $colisionAula = Horario::where('dia', $dia)
                // Obtenemos los GrupoMateria que usan la misma Aula
                ->whereHas('grupoMateria', function ($query) use ($aulaId) {
                    $query->where('aula_id', $aulaId);
                })
                // Regla de solapamiento: (A_inicio < B_fin) AND (A_fin > B_inicio)
                ->where('hora_inicio', '<', $fin)
                ->where('hora_fin', '>', $inicio)
                ->when($exceptId, function ($query) use ($exceptId) {
                    return $query->where('id', '!=', $exceptId);
                })
                ->first();
            
            if ($colisionAula) {
                $nombreDia = $this->dias[$dia];
                $errorMsg = "El Aula N° {$colisionAula->grupoMateria->aula->numero} ya está ocupada el {$nombreDia} de {$colisionAula->hora_inicio} a {$colisionAula->hora_fin} por la materia {$colisionAula->grupoMateria->materia->sigla}.";
                throw \Illuminate\Validation\ValidationException::withMessages(['grupo_materia_id' => $errorMsg]);
            }
        }

        // 2. Colisión de Docente (El mismo docente está ocupado a esa hora)
        if ($docenteId) {
            $colisionDocente = Horario::where('dia', $dia)
                // Obtenemos los GrupoMateria que tienen asignado al mismo Docente
                ->whereHas('grupoMateria', function ($query) use ($docenteId) {
                    $query->where('docente_id', $docenteId);
                })
                // Regla de solapamiento
                ->where('hora_inicio', '<', $fin)
                ->where('hora_fin', '>', $inicio)
                ->when($exceptId, function ($query) use ($exceptId) {
                    return $query->where('id', '!=', $exceptId);
                })
                ->first();

            if ($colisionDocente) {
                $nombreDia = $this->dias[$dia];
                $errorMsg = "El Docente ya está ocupado el {$nombreDia} de {$colisionDocente->hora_inicio} a {$colisionDocente->hora_fin} con la materia {$colisionDocente->grupoMateria->materia->sigla}.";
                throw \Illuminate\Validation\ValidationException::withMessages(['grupo_materia_id' => $errorMsg]);
            }
        }
    }
}