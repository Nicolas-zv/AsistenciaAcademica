<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Resultados del Reporte General
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700">
                <h1 class="text-2xl font-extrabold text-white mb-6 border-b border-gray-700 pb-2">
                    Resumen de Inasistencias por Docente
                </h1>

                @if ($estadisticas->isEmpty())
                    <p class="text-gray-400">No se encontraron inasistencias para los filtros seleccionados.</p>
                @else
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Docente</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">Total Faltas</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">Tardanzas</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">Ausencias</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-green-400 uppercase tracking-wider">Justificadas</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-red-400 uppercase tracking-wider">Injustificadas (CRÍTICO)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach ($estadisticas as $stats)
                                    <tr class="hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $stats['docente'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-300">{{ $stats['total_faltas'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-400">{{ $stats['tardanzas'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-red-400">{{ $stats['ausencias'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-green-400 font-bold">{{ $stats['justificadas'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-red-400 font-extrabold text-lg">{{ $stats['injustificadas'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                
                <h2 class="text-xl font-bold text-white mb-4 mt-8 border-b border-gray-700 pb-2">Detalle de Registros</h2>
                
                {{-- Muestra el detalle de cada asistencia que contribuyó al reporte --}}
                <div class="overflow-x-auto">
                    {{-- (Aquí puedes mostrar la tabla de asistencias, similar a asistencias.index, pero solo las filtradas) --}}
                    <p class="text-gray-400">Aquí se mostraría la tabla detallada de todas las inasistencias filtradas ($reporteData).</p>
                </div>
                
                <div class="flex justify-start mt-6">
                    <a href="{{ route('reportes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Nuevo Reporte
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>