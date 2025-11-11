<!DOCTYPE html>
<html>
<head>
    <title>{{ $titulo ?? 'Reporte PDF' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Estilos básicos para PDF (Dompdf prefiere estilos incrustados) */
        body { 
            font-family: sans-serif; 
            margin: 40px; 
            color: #333;
        }
        h1 { 
            color: #1a202c; /* Color oscuro */
            border-bottom: 2px solid #e2e8f0; 
            padding-bottom: 10px; 
            font-size: 18px; 
        }
        .metadata { 
            font-size: 10px; 
            margin-bottom: 20px; 
            color: #718096; /* Color gris */
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #e2e8f0; 
            padding: 8px; 
            font-size: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f7fafc; /* Fondo claro para cabeceras */
            color: #2d3748; 
            font-weight: bold;
        }
        .footer { 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            text-align: right; 
            font-size: 8px; 
            color: #999; 
        }
    </style>
</head>
<body>
    <h1>{{ $titulo ?? 'Reporte' }}</h1>

    <div class="metadata">
        Generado el: **{{ $generado_en }}**
        @if (!empty($filtros))
            <br>Filtros aplicados: 
            @if ($filtros['docente_id'] ?? false) <span>Docente ID: {{ $filtros['docente_id'] }}</span>@endif
            @if ($filtros['grupo_materia_id'] ?? false) <span> | Grupo/Materia ID: {{ $filtros['grupo_materia_id'] }}</span>@endif
            @if ($filtros['fecha_inicio'] ?? false) <span> | Desde: {{ $filtros['fecha_inicio'] }}</span>@endif
            @if ($filtros['fecha_fin'] ?? false) <span> | Hasta: {{ $filtros['fecha_fin'] }}</span>@endif
        @endif
    </div>

    @if ($reporteData->isEmpty())
        <p>No se encontraron registros de inasistencias o tardanzas con los filtros aplicados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Docente</th>
                    <th>Materia / Grupo</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    <th>Justificada</th>
                    <th>Motivo Justificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reporteData as $asistencia)
                    <tr>
                        <td>{{ optional(optional($asistencia->docente)->user)->nombre ?? 'N/A' }}</td>
                        <td>{{ optional(optional($asistencia->grupoMateria)->materia)->sigla ?? 'N/A' }} / {{ optional(optional($asistencia->grupoMateria)->grupo)->nombre ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                        <td>{{ optional($asistencia->horario)->hora_inicio ?? '' }} - {{ optional($asistencia->horario)->hora_fin ?? '' }}</td>
                        <td>{{ ucfirst($asistencia->estado) }}</td>
                        <td>{{ $asistencia->justificada ? 'Sí' : 'No' }}</td>
                        <td>{{ $asistencia->motivo_justificacion ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Generado por el sistema el {{ $generado_en }}
    </div>
</body>
</html>