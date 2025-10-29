{{-- resources/views/horarios/show.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle de Horario
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Horario para <span class="text-white">{{ $horario->grupoMateria->materia->sigla ?? 'N/A' }}</span>
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-4xl mx-auto">
                    
                    {{-- Botones de Acción --}}
                    <div class="flex justify-end space-x-3 mb-6">
                        <a href="{{ route('horarios.edit', $horario) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> **Editar Horario**
                        </a>
                        <a href="{{ route('horarios.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a Horarios
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- Columna 1: Información del Horario --}}
                        <div class="space-y-4">
                            <h2 class="text-xl font-bold text-gray-300 dark:text-gray-300 border-b border-gray-700 dark:border-gray-700 pb-2 mb-3">Detalles del Horario</h2>
                            
                            {{-- Aquí asumimos que tienes un partials/detail-row.blade.php que funciona, y adaptamos las clases directamente si no lo usas --}}
                            
                            {{-- Día --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Día:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $horario->dia_nombre }} <span class="text-gray-500 text-xs font-normal">(Día {{ $horario->dia }})</span></p>
                            </div>
                            
                            {{-- Inicio --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Inicio:</p>
                                <p class="w-2/3 text-base text-white dark:text-white">{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i A') }}</p>
                            </div>
                            
                            {{-- Fin --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Fin:</p>
                                <p class="w-2/3 text-base text-white dark:text-white">{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i A') }}</p>
                            </div>
                            
                            {{-- Duración --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Duración:</p>
                                <p class="w-2/3 text-base text-white dark:text-white">{{ \Carbon\Carbon::parse($horario->hora_inicio)->diff(\Carbon\Carbon::parse($horario->hora_fin))->format('%h horas y %i minutos') }}</p>
                            </div>
                            
                            {{-- Modalidad --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Modalidad:</p>
                                <p class="w-2/3 text-base text-white dark:text-white">{{ $horario->modalidad ?? 'No definida' }}</p>
                            </div>
                            
                            {{-- Estado --}}
                            <div class="flex items-start pt-2">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Estado:</p>
                                <p class="w-2/3 text-base font-bold uppercase 
                                    @if($horario->estado == 'vigente') text-green-400 
                                    @elseif($horario->estado == 'cancelado') text-red-400 
                                    @else text-yellow-400 
                                    @endif">
                                    {{ $horario->estado }}
                                </p>
                            </div>
                        </div>

                        {{-- Columna 2: Detalles de Asignación --}}
                        <div class="space-y-4">
                            <h2 class="text-xl font-bold text-gray-300 dark:text-gray-300 border-b border-gray-700 dark:border-gray-700 pb-2 mb-3">Asignación Académica</h2>
                            
                            {{-- Materia --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Materia:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-semibold">{{ $horario->grupoMateria->materia->nombre ?? 'N/A' }} <span class="text-gray-500 text-xs font-normal">({{ $horario->grupoMateria->materia->sigla ?? '' }})</span></p>
                            </div>
                            
                            {{-- Grupo --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Grupo:</p>
                                <p class="w-2/3 text-base text-white dark:text-white">{{ $horario->grupoMateria->grupo->nombre ?? 'N/A' }}</p>
                            </div>
                            
                            {{-- Gestión --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Gestión:</p>
                                <p class="w-2/3 text-base text-white dark:text-white">{{ ($horario->grupoMateria->gestion->año ?? 'N/A') . ' - ' . ($horario->grupoMateria->gestion->semestre ?? 'N/A') }}</p>
                            </div>
                            
                            {{-- Aula Asignada --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Aula Asignada:</p>
                                <p class="w-2/3 text-base text-white dark:text-white">{{ $horario->grupoMateria->aula->numero ?? 'Sin Aula' }} <span class="text-gray-500 text-xs font-normal">({{ $horario->grupoMateria->modulo->codigo ?? 'Sin Módulo' }})</span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Metadatos --}}
                    <div class="mt-8 pt-4 border-t border-gray-700 dark:border-gray-700 text-xs text-gray-500">
                        <p>Registro Creado: **{{ $horario->created_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $horario->created_at->diffForHumans() }})</p>
                        <p>Última Actualización: **{{ $horario->updated_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $horario->updated_at->diffForHumans() }})</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>