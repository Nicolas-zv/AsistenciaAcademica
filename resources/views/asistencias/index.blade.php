<x-app-layout>
    {{-- 1. HEADER: Pasa el título al slot $header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestión de Asistencias
        </h2>
    </x-slot>

    {{-- CONTENIDO PRINCIPAL DE LA VISTA --}}
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-white mb-6">
            Listado de Asistencias Registradas
        </h1>
        
        {{-- 🟢 AQUÍ VA EL BOTÓN DE CREACIÓN 🟢 --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('asistencias.create') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-200 flex items-center space-x-2">
               <i class="fa-solid fa-plus-circle"></i>
               <span>Registrar Asistencia</span>
            </a>
        </div>
        {{-- FIN DEL BOTÓN DE CREACIÓN --}}

        {{-- 🟢 1. CONTENEDOR EXTERIOR (ESTILO Y FONDO OSCURO) 🟢 --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700">
            
            {{-- 🛑 2. CONTENEDOR INTERIOR (SCROLL HORIZONTAL) 🛑 --}}
            <div class="overflow-x-auto">
            
                <table class="divide-y divide-gray-700">
                    
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Docente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap">Fecha / Hora</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Materia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Horario</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                            
                            {{-- 🟢 ADICIÓN CU14 🟢 --}}
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Justificada</th>
                            
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-800">
                        @foreach ($asistencias as $asistencia)
                            <tr class="hover:bg-gray-700/50 transition">
                                
                                {{-- CELDA 1: Docente --}}
                                <td class="px-6 py-4 text-sm font-medium text-white">
                                    {{ optional(optional($asistencia->docente)->user)->nombre ?? 'N/A' }}
                                </td>
                                
                                {{-- CELDA 2: Fecha / Hora --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/M/Y') }}
                                    @if($asistencia->hora)
                                        <span class="text-xs text-gray-500 block">{{ \Carbon\Carbon::parse($asistencia->hora)->format('H:i') }}</span>
                                    @endif
                                </td>
                                
                                {{-- CELDA 3: Materia --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ optional(optional($asistencia->grupoMateria)->materia)->sigla ?? 'N/A' }}
                                </td>
                                
                                {{-- CELDA 4: Horario --}}
                                <td class="px-6 py-4 text-sm text-gray-300">
                                    {{ optional($asistencia->horario)->dia_nombre ?? 'N/A' }} 
                                    <span class="text-xs text-gray-500 block">
                                        {{ optional($asistencia->horario)->hora_inicio ?? '' }} - {{ optional($asistencia->horario)->hora_fin ?? '' }}
                                    </span>
                                </td>
                                
                                {{-- CELDA 5: Estado --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold">
                                    @php
                                        $statusClass = match ($asistencia->estado) {
                                            'presente' => 'bg-green-600',
                                            'ausente' => 'bg-red-600',
                                            'tarde' => 'bg-yellow-600',
                                            default => 'bg-gray-500', 
                                        };
                                        $spanClass = "px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white " . $statusClass;
                                    @endphp
                                    
                                    <span class="{{ $spanClass }}">
                                        {{ ucfirst($asistencia->estado) }}
                                    </span>
                                </td>
                                
                                {{-- 🟢 ADICIÓN CU14: CELDA JUSTIFICADA 🟢 --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold">
                                    @if (isset($asistencia->justificada) && $asistencia->justificada)
                                        <i class="fa-solid fa-check-circle text-green-400 mr-1" title="{{ $asistencia->motivo_justificacion }}"></i>
                                        <span class="text-green-400">Sí</span>
                                    @else
                                        <i class="fa-solid fa-xmark-circle text-red-400 mr-1"></i>
                                        <span class="text-red-400">No</span>
                                    @endif
                                </td>

                                
                                {{-- CELDA 6: Tipo --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-xs text-gray-400">
                                    {{ ucfirst($asistencia->tipo_registro ?? 'N/A') }}
                                </td>
                                
                                {{-- CELDA 7: Acciones --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        
                                        {{-- 🟢 ADICIÓN CU14: BOTÓN JUSTIFICAR 🟢 --}}
                                        @if ($asistencia->estado !== 'presente' && (!isset($asistencia->justificada) || !$asistencia->justificada))
                                            <a href="{{ route('asistencias.justificar.show', $asistencia->id) }}" 
                                               class="text-teal-400 hover:text-teal-300 transition" title="Justificar Inasistencia">
                                                <i class="fa-solid fa-gavel"></i>
                                            </a>
                                        @endif
                                        
                                        {{-- Ver --}}
                                        <a href="{{ route('asistencias.show', $asistencia->id) }}" 
                                        class="text-indigo-400 hover:text-indigo-300 transition" title="Ver">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        {{-- Editar --}}
                                        <a href="{{ route('asistencias.edit', $asistencia->id) }}" 
                                        class="text-yellow-400 hover:text-yellow-300 transition" title="Editar">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        {{-- Eliminar --}}
                                        <form action="{{ route('asistencias.destroy', $asistencia->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro de asistencia?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            
            </div>
            
            {{-- Paginación --}}
            <div class="mt-4">
                {{ $asistencias->links() }}
            </div>
        </div>
    </div>
</x-app-layout>