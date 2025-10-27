<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Docente;
use App\Models\GrupoMateria;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;

class AsistenciaController extends Controller
{
    // Carga los catálogos necesarios para los formularios
    protected function loadCatalogs()
    {
        // 1. Cargar Docentes con su relación 'user' para evitar N+1 y acceder seguro al nombre
        $docentes = Docente::with('user')->get()->mapWithKeys(function ($docente) {
            
            $nombre = optional($docente->user)->name;
            
            if (!$nombre) {
                // Si no hay user->name, usa el código o un marcador
                $nombre = $docente->codigo ? 'Docente Cód: ' . $docente->codigo : 'Docente S/U';
            }

            return [$docente->id => $nombre];
        })->sort();

        // 2. Cargar GrupoMaterias con todas sus relaciones para el listado
        $grupoMaterias = GrupoMateria::with(['materia', 'grupo', 'gestion'])
            ->get()
            ->mapWithKeys(function ($gm) {
                // Usar optional() para acceder de forma segura a relaciones anidadas que podrían ser null
                $sigla = optional($gm->materia)->sigla ?? 'N/A';
                $grupo = optional($gm->grupo)->nombre ?? 'N/A';
                $gestion = optional($gm->gestion)->año ?? 'N/A';

                $nombre = "{$sigla}-{$grupo} ({$gestion})";
                return [$gm->id => $nombre];
            })->sort();
            
        // 3. Cargar Horarios con relaciones anidadas
        $horarios = Horario::with(['grupoMateria.materia'])
            ->get()
            ->mapWithKeys(function ($h) {
                // NOTA: Requiere el accesor getDiaNombreAttribute() en Horario.php

                // Acceso seguro a la sigla de la materia
                $sigla = optional(optional($h->grupoMateria)->materia)->sigla ?? 'N/A';

                // Composición final del nombre
                $nombre = "{$h->dia_nombre} | {$h->hora_inicio} - {$h->hora_fin} ({$sigla})";
                
                return [$h->id => $nombre];
            })->sort();

        return compact('docentes', 'grupoMaterias', 'horarios');
    }

    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        // Carga relaciones para la visualización
        $asistencias = Asistencia::with(['docente.user', 'grupoMateria.materia', 'horario'])
                                 ->orderBy('fecha', 'desc')
                                 ->orderBy('hora', 'desc')
                                 ->paginate(20);

        return view('asistencias.index', compact('asistencias'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $catalogs = $this->loadCatalogs();
        return view('asistencias.create', $catalogs);
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_materia_id' => 'nullable|exists:grupo_materia,id',
            'horario_id' => 'nullable|exists:horarios,id',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i',
            'estado' => ['required', 'string', Rule::in(['presente', 'ausente', 'tarde'])],
            'observacion' => 'nullable|string|max:500',
            'tipo_registro' => ['nullable', 'string', Rule::in(['manual', 'qr', 'codigo'])],
        ]);

        // Asignar el usuario que registra la asistencia
        $validatedData['registrado_por'] = Auth::id(); 
        if (empty($validatedData['tipo_registro'])) {
             $validatedData['tipo_registro'] = 'manual';
        }

        Asistencia::create($validatedData);

        return redirect()->route('asistencias.index')
                         ->with('success', 'Asistencia registrada exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Asistencia $asistencia)
    {
        // Carga el registrador para mostrar quién hizo el registro
        $asistencia->load('registrador');
        return view('asistencias.show', compact('asistencia'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Asistencia $asistencia)
    {
        $catalogs = $this->loadCatalogs();
        return view('asistencias.edit', array_merge(compact('asistencia'), $catalogs));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $validatedData = $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_materia_id' => 'nullable|exists:grupo_materia,id',
            'horario_id' => 'nullable|exists:horarios,id',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i',
            'estado' => ['required', 'string', Rule::in(['presente', 'ausente', 'tarde'])],
            'observacion' => 'nullable|string|max:500',
            'tipo_registro' => ['nullable', 'string', Rule::in(['manual', 'qr', 'codigo'])],
        ]);

        $asistencia->update($validatedData);

        return redirect()->route('asistencias.index')
                         ->with('success', 'Asistencia actualizada exitosamente.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();

        return redirect()->route('asistencias.index')
                         ->with('success', 'Registro de asistencia eliminado correctamente.');
    }
}