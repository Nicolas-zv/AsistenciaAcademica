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

            // Asumiendo que 'name' en la tabla 'users' contiene el nombre del docente
            $nombre = optional($docente->user)->nombre;

            if (!$nombre) {
                // Si no hay user->name, usa el código o un marcador
                $nombre = $docente->codigo ? 'Docente Cód: ' . $docente->codigo : 'Docente S/U';
            }

            // 🛑 CORRECCIÓN CLAVE: Usar $docente->user_id como clave 🛑
            return [$docente->id => $nombre];
        })->sort();

        // 2. Cargar GrupoMaterias con todas sus relaciones para el listado (Sin cambios)
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

        // 3. Cargar Horarios con relaciones anidadas (Sin cambios)
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
        // 1. Validaciones básicas
        $validatedData = $request->validate([
            'docente_id' => 'required|exists:docentes,id', // 🛑 IMPORTANTE: Cambiado a user_id
            'grupo_materia_id' => 'required|exists:grupo_materia,id', // 🛑 Cambiado a required si es manual
            'horario_id' => 'required|exists:horarios,id', // 🛑 Cambiado a required si es manual
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i', // 🛑 Cambiado a required
            'estado' => ['required', 'string', Rule::in(['presente', 'ausente', 'tarde'])],
            'observacion' => 'nullable|string|max:500',
            'tipo_registro' => ['nullable', 'string', Rule::in(['manual', 'qr', 'codigo'])],
        ]);

        // Usaremos $data en lugar de $validatedData para modificar el estado y las claves
        $data = $validatedData;

        // 2. Lógica de validación de CU13

        // A. Validar Día y Unicidad con Horario
        $horario = Horario::find($data['horario_id']);

        if (!$horario) {
            return back()->withErrors(['horario_id' => 'El horario seleccionado no es válido.'])->withInput();
        }

        $fechaAsistencia = Carbon::parse($data['fecha']);
        // 2.1. Validar que el día de la semana coincida
        if ($fechaAsistencia->dayOfWeek !== $horario->dia) {
            return back()->withErrors([
                'fecha' => 'La fecha seleccionada no corresponde al día de la semana programado para este horario (' . $horario->dia_nombre . ').'
            ])->withInput();
        }

        // 2.2. Validar Unicidad (mismo docente, grupo, horario y fecha)
        $existe = Asistencia::where('docente_id', $data['docente_id'])
                            ->where('grupo_materia_id', $data['grupo_materia_id'])
                            ->where('horario_id', $data['horario_id'])
                            ->whereDate('fecha', $data['fecha'])
                            ->exists();

        if ($existe) {
            return back()->withErrors([
                'general' => 'Ya existe un registro de asistencia para este docente, materia y horario en la fecha seleccionada.'
            ])->withInput();
        }

        // 3. Lógica de Estado Automático: "Tarde"

        $horaAsistencia = Carbon::parse($data['hora']);
        $horaInicio = Carbon::parse($horario->hora_inicio);
        $toleranciaMinutos = 10; // Definimos la tolerancia de 10 minutos

        // Si la hora de asistencia es posterior a la hora de inicio + tolerancia
        if ($horaAsistencia->greaterThan($horaInicio->addMinutes($toleranciaMinutos))) {
            // Solo si el estado enviado era 'presente', lo cambiamos a 'tarde'
            if ($data['estado'] === 'presente') {
                $data['estado'] = 'tarde';
            }
        }

        // 4. Crear el registro
        $data['registrado_por'] = $request->user()->id;
        if (empty($data['tipo_registro'])) {
            $data['tipo_registro'] = 'manual';
        }

        Asistencia::create($data);

        return redirect()->route('asistencias.index')
                        ->with('success', 'Asistencia registrada exitosamente. Estado: ' . ucfirst($data['estado']));
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
        // 1. Validaciones básicas
        $validatedData = $request->validate([
            'docente_id' => 'required|exists:docentes,id', // 🛑 IMPORTANTE: Cambiado a user_id
            'grupo_materia_id' => 'required|exists:grupo_materia,id', // 🛑 Cambiado a required si es manual
            'horario_id' => 'required|exists:horarios,id', // 🛑 Cambiado a required si es manual
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i', // 🛑 Cambiado a required
            'estado' => ['required', 'string', Rule::in(['presente', 'ausente', 'tarde'])],
            'observacion' => 'nullable|string|max:500',
            'tipo_registro' => ['nullable', 'string', Rule::in(['manual', 'qr', 'codigo'])],
        ]);

        $data = $validatedData;

        // 2. Lógica de validación de CU13

        // A. Validar Día y Unicidad con Horario
        $horario = Horario::find($data['horario_id']);

        if (!$horario) {
            return back()->withErrors(['horario_id' => 'El horario seleccionado no es válido.'])->withInput();
        }

        $fechaAsistencia = Carbon::parse($data['fecha']);
        // 2.1. Validar que el día de la semana coincida
        if ($fechaAsistencia->dayOfWeek !== $horario->dia) {
            return back()->withErrors([
                'fecha' => 'La fecha seleccionada no corresponde al día de la semana programado para este horario (' . $horario->dia_nombre . ').'
            ])->withInput();
        }

        // 2.2. Validar Unicidad (mismo docente, grupo, horario y fecha) - IGNORANDO EL REGISTRO ACTUAL
        $existe = Asistencia::where('docente_id', $data['docente_id'])
                            ->where('grupo_materia_id', $data['grupo_materia_id'])
                            ->where('horario_id', $data['horario_id'])
                            ->whereDate('fecha', $data['fecha'])
                            ->where('id', '!=', $asistencia->id) // 🛑 Ignorar el registro que estamos editando
                            ->exists();

        if ($existe) {
            return back()->withErrors([
                'general' => 'Ya existe otro registro de asistencia con la misma combinación de docente, materia, horario y fecha.'
            ])->withInput();
        }

        // 3. Lógica de Estado Automático: "Tarde" (misma lógica que en store)

        $horaAsistencia = Carbon::parse($data['hora']);
        $horaInicio = Carbon::parse($horario->hora_inicio);
        $toleranciaMinutos = 10;

        if ($horaAsistencia->greaterThan($horaInicio->addMinutes($toleranciaMinutos))) {
            if ($data['estado'] === 'presente') {
                $data['estado'] = 'tarde';
            }
        }

        // 4. Actualizar el registro
        $asistencia->update($data);

        return redirect()->route('asistencias.index')
                        ->with('success', 'Asistencia actualizada exitosamente. Estado: ' . ucfirst($data['estado']));
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
    /**
     * Muestra el formulario para justificar una inasistencia específica.
     */
    public function showJustificationForm(Asistencia $asistencia)
    {
        // Restricción: Solo permitir justificar si el estado es 'ausente' o 'tarde'
        if ($asistencia->estado === 'presente' || $asistencia->justificada) {
            return redirect()->route('asistencias.index')->with('error', 'Esta asistencia no puede ser justificada.');
        }

        // Asegúrate de tener la relación 'docente.user' cargada para mostrar el nombre
        $asistencia->load('docente.user');

        return view('asistencias.justificar', compact('asistencia'));
    }

    /**
     * Procesa la justificación y actualiza el registro de asistencia.
     */
    public function justify(Request $request, Asistencia $asistencia)
    {
        // Restricción de seguridad adicional
        if ($asistencia->estado === 'presente' || $asistencia->justificada) {
            return redirect()->route('asistencias.index')->with('error', 'Error de procesamiento: La asistencia ya fue manejada.');
        }

        // 1. Validar el motivo
        $validated = $request->validate([
            'motivo' => 'required|string|min:10|max:500',
        ]);

        // 2. Actualizar la asistencia
        $asistencia->update([
            'justificada' => true,
            'motivo_justificacion' => $validated['motivo'],
            // Registrar al usuario logueado (administrador) que aprueba la justificación
            'aprobado_por' => $request->user()->id,
        ]);

        return redirect()->route('asistencias.index')->with('success', 'La inasistencia ha sido justificada y aprobada con éxito.');
    }
}
