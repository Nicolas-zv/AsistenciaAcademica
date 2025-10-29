{{-- resources/views/grupo_materia/show.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle de Asignación
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    {{ $grupoMateria->materia->sigla ?? 'N/A' }} - {{ $grupoMateria->grupo->nombre ?? 'N/A' }} ({{ $grupoMateria->gestion->año ?? 'N/A' }})
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-4xl mx-auto">
                    
                    {{-- Botones de Acción --}}
                    <div class="flex justify-end space-x-3 mb-8">
                        <a href="{{ route('grupo_materia.edit', $grupoMateria) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> **Editar Asignación**
                        </a>
                        <a href="{{ route('grupo_materia.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 dark:text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a Asignaciones
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- Columna 1: Datos Principales --}}
                        <div class="space-y-4">
                            <h2 class="text-xl font-bold text-gray-300 dark:text-gray-300 border-b border-gray-700 dark:border-gray-700 pb-2 mb-3">Datos Académicos</h2>
                            
                            {{-- Detalle: Docente Asignado (AÑADIDO) --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-green-400">Docente:</p>
                                <p class="w-2/3 text-base text-yellow-300 dark:text-yellow-300 font-bold">
                                    {{ $grupoMateria->docente->nombre_completo ?? 'PENDIENTE DE ASIGNACIÓN' }}
                                </p>
                            </div>
                            
                            {{-- Materia --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Materia:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $grupoMateria->materia->nombre ?? 'N/A' }}</p>
                                @if($grupoMateria->materia->sigla ?? null)
                                    <span class="text-gray-500 text-sm ml-2">({{ $grupoMateria->materia->sigla }})</span>
                                @endif
                            </div>

                            {{-- Grupo --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Grupo:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $grupoMateria->grupo->nombre ?? 'N/A' }}</p>
                            </div>

                            {{-- Gestión --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Gestión:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">
                                    {{ ($grupoMateria->gestion->año ?? 'N/A') . ' - ' . ($grupoMateria->gestion->semestre ?? 'N/A') }}
                                </p>
                            </div>

                            {{-- Turno --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Turno:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $grupoMateria->turno ?? 'No asignado' }}</p>
                            </div>

                            {{-- Cupo Máximo --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Cupo Máximo:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $grupoMateria->cupo ?? 'N/A' }}</p>
                            </div>
                            
                            {{-- Estado --}}
                            <div class="flex items-start pt-2">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Estado:</p>
                                <p class="w-2/3 text-base font-bold uppercase 
                                    @if ($grupoMateria->estado == 'activo') 
                                        text-green-500 
                                    @elseif ($grupoMateria->estado == 'cerrado')
                                        text-red-500
                                    @else
                                        text-sky-500
                                    @endif
                                ">**{{ $grupoMateria->estado }}**</p>
                            </div>
                        </div>

                        {{-- Columna 2: Ubicación --}}
                        <div class="space-y-4">
                            <h2 class="text-xl font-bold text-gray-300 dark:text-gray-300 border-b border-gray-700 dark:border-gray-700 pb-2 mb-3">Ubicación Asignada</h2>
                            
                            {{-- Módulo --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Módulo:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $grupoMateria->modulo->nombre ?? 'Sin Módulo' }}</p>
                                @if($grupoMateria->modulo->codigo ?? null)
                                    <span class="text-gray-500 text-sm ml-2">({{ $grupoMateria->modulo->codigo }})</span>
                                @endif
                            </div>

                            {{-- Aula --}}
                            <div class="flex items-start">
                                <p class="w-1/3 text-sm font-medium text-gray-400">Aula:</p>
                                <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $grupoMateria->aula->numero ?? 'Sin Aula' }}</p>
                                @if($grupoMateria->aula->tipo ?? null)
                                    <span class="text-gray-500 text-sm ml-2">({{ $grupoMateria->aula->tipo }})</span>
                                @endif
                            </div>
                            
                            @if($grupoMateria->aula)
                            <div class="pt-4">
                                <p class="text-sm font-medium text-gray-400 mb-2">Detalles del Aula:</p>
                                <div class="bg-gray-700/50 p-3 rounded-md text-gray-400 text-sm border border-gray-600">
                                    Capacidad: <span class="font-bold text-indigo-400">{{ $grupoMateria->aula->capacidad ?? 'N/A' }}</span> personas.
                                    <span class="block">Ubicación: {{ $grupoMateria->aula->ubicacion ?? 'No especificada.' }}</span>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>

                    {{-- Metadatos --}}
                    <div class="mt-10 pt-4 border-t border-gray-700 dark:border-gray-700 text-xs text-gray-500">
                        <p>Registro Creado: **{{ $grupoMateria->created_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $grupoMateria->created_at->diffForHumans() }})</p>
                        <p>Última Actualización: **{{ $grupoMateria->updated_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $grupoMateria->updated_at->diffForHumans() }})</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>