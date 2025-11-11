{{-- resources/views/asistencias/show.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle de Asistencia
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">
                <div class="max-w-xl mx-auto bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-700">
                    
                    <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-gray-700 pb-4">
                        <i class="fa-solid fa-info-circle mr-2 text-indigo-400"></i> Registro #{{ $asistencia->id }}
                    </h1>

                    <div class="space-y-4">
                        {{-- Docente --}}
                        <div class="border-b border-gray-700 pb-2">
                            <p class="text-sm font-medium text-gray-400">Docente</p>
                            <p class="text-white text-lg font-semibold">{{ optional(optional($asistencia->docente)->user)->nombre ?? 'N/A' }}</p>
                        </div>

                        {{-- Estado --}}
                        <div class="border-b border-gray-700 pb-2">
                            <p class="text-sm font-medium text-gray-400">Estado</p>
                            @php
                                $statusClass = [
                                    'presente' => 'bg-green-600',
                                    'ausente' => 'bg-red-600',
                                    'tarde' => 'bg-yellow-600',
                                ][$asistencia->estado] ?? 'bg-gray-500';
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full text-white {{ $statusClass }}">
                                {{ ucfirst($asistencia->estado) }}
                            </span>
                        </div>
                        
                        {{-- Fecha y Hora --}}
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-700 pb-2">
                            <div>
                                <p class="text-sm font-medium text-gray-400">Fecha</p>
                                <p class="text-white">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/M/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-400">Hora</p>
                                <p class="text-white">{{ $asistencia->hora ? \Carbon\Carbon::parse($asistencia->hora)->format('H:i') : 'N/A' }}</p>
                            </div>
                        </div>

                        {{-- Materia y Horario --}}
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-700 pb-2">
                            <div>
                                <p class="text-sm font-medium text-gray-400">Grupo / Materia</p>
                                <p class="text-white">{{ optional(optional($asistencia->grupoMateria)->materia)->sigla ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ optional(optional($asistencia->grupoMateria)->grupo)->nombre ?? '' }} ({{ optional(optional($asistencia->grupoMateria)->gestion)->año ?? '' }})</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-400">Horario Programado</p>
                                <p class="text-white">{{ optional($asistencia->horario)->dia_nombre ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ optional($asistencia->horario)->hora_inicio ?? '' }} - {{ optional($asistencia->horario)->hora_fin ?? '' }}</p>
                            </div>
                        </div>

                        {{-- Tipo de Registro y Registrado Por --}}
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-700 pb-2">
                            <div>
                                <p class="text-sm font-medium text-gray-400">Tipo de Registro</p>
                                <p class="text-white">{{ ucfirst($asistencia->tipo_registro ?? 'Manual') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-400">Registrado Por</p>
                                <p class="text-white">{{ optional($asistencia->registrador)->name ?? 'Sistema' }}</p>
                            </div>
                        </div>

                        {{-- Observación --}}
                        <div class="pt-2">
                            <p class="text-sm font-medium text-gray-400">Observación</p>
                            <p class="text-white bg-gray-700 p-3 rounded-lg">{{ $asistencia->observacion ?? 'Sin observación.' }}</p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('asistencias.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver al Listado
                        </a>
                        <a href="{{ route('asistencias.edit', $asistencia->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                            <i class="fa-solid fa-edit mr-2"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>