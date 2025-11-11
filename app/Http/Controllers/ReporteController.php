<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Docente;
use App\Models\GrupoMateria;
use Barryvdh\DomPDF\Facade\Pdf; // IMPORTANTE: Facade para el PDF
use Carbon\Carbon; // Usar Carbon para manejo de fechas
use App\Models\Reporte;
use Illuminate\Http\RedirectResponse;
class ReporteController extends Controller
{
    /**
     * Retorna la consulta de datos del reporte basada en los filtros.
     */
    private function getReportQuery(Request $request)
    {
        // La consulta base busca inasistencias (ausente, tarde)
        $query = Asistencia::with(['docente.user', 'grupoMateria.materia', 'grupoMateria.grupo', 'horario'])
            ->whereIn('estado', ['ausente', 'tarde']); 
        
        // Aplicar filtros
        if ($request->filled('docente_id')) {
            $query->where('docente_id', $request->docente_id);
        }

        if ($request->filled('grupo_materia_id')) {
            $query->where('grupo_materia_id', $request->grupo_materia_id);
        }

        if ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }
        
        // Retorna la colección ordenada
        return $query->orderBy('fecha', 'desc')->get();
    }

    /**
     * Muestra la interfaz de filtros del reporte.
     */
    public function index()
    {
        $docentes = Docente::with('user')->get()->pluck('user.nombre', 'id')->toArray();
        $gruposMateria = GrupoMateria::with(['materia', 'grupo'])->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->materia->sigla . ' - ' . $item->grupo->nombre];
        })->toArray();

        return view('reportes.index', compact('docentes', 'gruposMateria'));
    }

    /**
     * Genera y muestra el reporte en la pantalla.
     */
    public function generate(Request $request)
    {
        $reporteData = $this->getReportQuery($request);
        
        // Recarga los datos estáticos para la vista
        $docentes = Docente::with('user')->get()->pluck('user.nombre', 'id')->toArray();
        $gruposMateria = GrupoMateria::with(['materia', 'grupo'])->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->materia->sigla . ' - ' . $item->grupo->nombre];
        })->toArray();

        return view('reportes.index', compact('reporteData', 'docentes', 'gruposMateria'));
    }

    /**
     * Exporta el reporte a PDF usando dompdf.
     */
    public function exportPdf(Request $request)
    {
        $reporteData = $this->getReportQuery($request);
        
        // Datos que se pasan a la plantilla Blade del PDF
        $data = [
            'reporteData' => $reporteData,
            'titulo' => 'Reporte Consolidado de Inasistencias y Tardanzas',
            'filtros' => $request->all(),
            // AQUI SE DEFINE LA VARIABLE $generado_en
            'generado_en' => Carbon::now()->format('d/m/Y H:i:s'), 
        ];

        // Carga la vista blade 'reportes.pdf-template' 
        $pdf = Pdf::loadView('reportes.pdf-template', $data);

        // Descarga el archivo
        return $pdf->download('reporte_asistencias_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }
    public function updateStatus(Asistencia $asistencia): RedirectResponse
    {
        // Usaremos 'resuelto' como el estado final de gestión
        // Y 'ausente' como el estado que marca la necesidad de gestión
        
        if ($asistencia->estado === 'ausente' || $asistencia->estado === 'tarde') {
            $asistencia->estado = 'resuelto';
            $message = 'Asistencia ID ' . $asistencia->id . ' (Docente: ' . $asistencia->docente->user->nombre . ') ha sido marcada como RESUELTA.';
        } else {
            // Opción para revertir, si es necesario. Podrías elegir no implementarla.
            $asistencia->estado = 'ausente'; // O el estado original que desees
            $message = 'Asistencia ID ' . $asistencia->id . ' ha sido marcada como PENDIENTE de nuevo.';
        }

        // Guardar el cambio en la base de datos de asistencias
        $asistencia->save();

        // Redirigir de vuelta a la lista de reportes/filtros
        // Nota: El reporte.index de tu código lista asistencias ausentes/tardanzas
        return redirect()->route('reportes.index')->with('success', $message);
    }
}