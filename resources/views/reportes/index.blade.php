<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reportes Generales (CU15)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700">
                <h1 class="text-2xl font-extrabold text-white mb-6 border-b border-gray-700 pb-2">
                    <i class="fa-solid fa-chart-bar mr-2 text-blue-400"></i> Filtrar Reporte
                </h1>
                
                {{-- La acción de este formulario ahora debe ser la ruta base para generar en pantalla --}}
                <form method="GET" action="{{ route('reportes.generate') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    
                    {{-- Filtro Docente --}}
                    <div>
                        <label for="docente_id" class="block text-sm font-medium text-gray-300">Docente</label>
                        <select id="docente_id" name="docente_id" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm">
                            <option value="">-- Todos los Docentes --</option>
                            @foreach ($docentes as $id => $nombre)
                                <option value="{{ $id }}" {{ request('docente_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro Grupo/Materia --}}
                    <div>
                        <label for="grupo_materia_id" class="block text-sm font-medium text-gray-300">Grupo/Materia</label>
                        <select id="grupo_materia_id" name="grupo_materia_id" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm">
                            <option value="">-- Todas las Materias --</option>
                            @foreach ($gruposMateria as $id => $nombre)
                                <option value="{{ $id }}" {{ request('grupo_materia_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Fecha Inicio --}}
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-300">Fecha Desde</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm">
                    </div>

                    {{-- Fecha Fin --}}
                    <div>
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-300">Fecha Hasta</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm">
                    </div>

                    {{-- Botones de Acción --}}
                    {{-- Usamos md:col-span-4 para ocupar todo el ancho al final --}}
                    <div class="md:col-span-4 flex justify-end space-x-4">
                        
                        <!-- Botón 1: Ver Reporte en Pantalla (Acción por defecto del form) -->
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                            <i class="fa-solid fa-chart-line mr-2"></i> Ver Reporte
                        </button>
                        
                        <!-- Botón 2: Exportar PDF (Usa formaction para anular la acción por defecto del form) -->
                        <button type="submit" formaction="{{ route('reportes.export.pdf') }}" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                            <i class="fa-solid fa-file-pdf mr-2"></i> Exportar PDF
                        </button>
                    </div>
                </form>
            </div>
            
            {{-- Sección de Resultados (Solo si hay datos para mostrar) --}}
            @isset($reporteData)
                <div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700">
                    <h2 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">
                        <i class="fa-solid fa-table mr-2 text-yellow-400"></i> Resultados del Reporte
                    </h2>

                    @if ($reporteData->isEmpty())
                        <p class="text-gray-400">No se encontraron registros de inasistencias o tardanzas con los filtros aplicados.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Docente</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Materia / Grupo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Horario</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Justificada</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Motivo</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider whitespace-nowrap">Acción (Gestión)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    @foreach ($reporteData as $asistencia)
                                        <tr class="hover:bg-gray-700 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ optional(optional($asistencia->docente)->user)->nombre ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ optional(optional($asistencia->grupoMateria)->materia)->sigla ?? 'N/A' }} / {{ optional(optional($asistencia->grupoMateria)->grupo)->nombre ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ optional($asistencia->horario)->hora_inicio ?? '' }} - {{ optional($asistencia->horario)->hora_fin ?? '' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $asistencia->estado == 'ausente' ? 'text-red-400' : 'text-yellow-400' }}">{{ ucfirst($asistencia->estado) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $asistencia->justificada ? 'Sí' : 'No' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $asistencia->motivo_justificacion ?? 'N/A' }}</td>
                                            {{-- ⭐ NUEVA CELDA DE ACCIONES ⭐ --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                @if ($asistencia->estado == 'ausente' || $asistencia->estado == 'tarde')
                                                    {{-- Formulario para marcar como RESUELTO --}}
                                                    <form action="{{ route('reportes.updateStatus', $asistencia) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                title="Marcar esta asistencia como gestionada/resuelta" 
                                                                class="bg-green-600 hover:bg-green-700 text-white font-semibold text-xs py-1 px-3 rounded shadow transition duration-150">
                                                            Resuelto
                                                        </button>
                                                    </form>
                                                @else
                                                    {{-- Mensaje para asistencias ya gestionadas --}}
                                                    <span class="text-xs text-gray-400">Gestionada</span>
                                                @endif
                                            </td>
                                            {{-- FIN DE LA NUEVA CELDA --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endisset

        </div>
    </div>
</x-app-layout>