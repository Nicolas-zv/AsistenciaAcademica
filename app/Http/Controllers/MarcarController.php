<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Docente;
use App\Models\GrupoMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class MarcarController extends Controller
{
    /**
     * Mostrar lista de asistencias del docente.
     */
    public function index()
    {
        $user = Auth::user();

        // Validar rol
        $rol = $user->role->nombre ?? null;
        if ($rol !== 'docente') {
            return redirect()->route('dashboard')
                ->with('error', 'Solo los docentes pueden acceder a esta sección.');
        }

        // Buscar docente asociado
        $docente = Docente::where('user_id', $user->correo)->first();

        if (!$docente) {
            return back()->with('error', 'No se encontró un docente asociado a tu cuenta.');
        }

        // Obtener asistencias del docente
        $asistenciasdocente = Asistencia::with(['grupoMateria.materia', 'grupoMateria.gestion'])
            ->where('docente_id', $docente->id)
            ->orderBy('fecha', 'desc')
            ->paginate(15);

        return view('asistencias.asistenciasindividual', compact('asistenciasdocente'));
    }

    /**
     * Mostrar formulario para marcar asistencia.
     */
    public function create()
    {
        $user = Auth::user();
        // 🧩 1️⃣ Verificamos el usuario actual

        $docente = Docente::where('user_id', $user->correo)->first();
        // 🧩 2️⃣ Verificamos si el docente existe

        if (!$docente) {
            return back()->with('error', 'No se encontró un docente asociado a tu cuenta.');
        }

        // 🧠 IMPORTANTE: docente_id en grupo_materia guarda el ID numérico del docente (no el correo)
        $grupoMaterias = \App\Models\GrupoMateria::with(['materia', 'grupo', 'gestion'])
            ->where('docente_id', $docente->id) // 👈 CAMBIO: debe usar id numérico si migración usa BIGINT
            ->get();


        // Si no hay materias asignadas, mostrar mensaje
        if ($grupoMaterias->isEmpty()) {
            return back()->with('error', 'No tienes materias asignadas actualmente.');
        }

        // Mapear resultados para mostrar en el select
        $grupoMateriasMap = $grupoMaterias->mapWithKeys(function ($gm) {
            $sigla = optional($gm->materia)->sigla ?? 'N/A';
            $grupo = optional($gm->grupo)->nombre ?? 'N/A';
            $gestion = optional($gm->gestion)->año ?? 'N/A';
            return [$gm->id => "{$sigla} - {$grupo} ({$gestion})"];
        });



        return view('asistencias.marcar', compact('grupoMateriasMap'));
    }


    /**
     * Guardar asistencia marcada por el docente.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $docente = Docente::where('user_id', $user->correo)->first();

        if (!$docente) {
            return back()->with('error', 'No se encontró un docente asociado a tu cuenta.');
        }

        $validated = $request->validate([
            'grupo_materia_id' => 'required|exists:grupo_materia,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'estado' => ['required', Rule::in(['presente', 'tarde', 'ausente'])],
            'observacion' => 'nullable|string|max:255',
        ]);

        // ✅ Guardar correctamente los IDs numéricos
        $validated['docente_id'] = $docente->id;       // bigint (ok)
        $validated['tipo_registro'] = 'manual';
        $validated['registrado_por'] = $user->id;      // bigint (ok, evita error)

        \App\Models\Asistencia::create($validated);

        return redirect()->route('marcar.index')
            ->with('success', 'Asistencia marcada correctamente.');
    }
}
