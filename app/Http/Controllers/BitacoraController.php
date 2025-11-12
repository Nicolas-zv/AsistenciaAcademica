<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class BitacoraController extends Controller
{
    /**
     * Muestra la lista de actividades registradas (bitácora) con filtro por fecha.
     */
    public function index(Request $request)
    {
        $query = Activity::with(['causer', 'subject'])->orderBy('created_at', 'desc');

        // Filtro por rango de fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59',
            ]);
        }

        $actividades = $query->paginate(15)->appends($request->only(['fecha_inicio', 'fecha_fin']));

        return view('bitacora.index', compact('actividades'));
    }
}
