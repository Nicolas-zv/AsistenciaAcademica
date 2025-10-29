{{-- resources/views/materias/show.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle de Materia
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Detalle de Materia: <span class="text-white dark:text-white">{{ $materia->nombre }}</span>
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto">
                    
                    {{-- Botones de Acción --}}
                    <div class="flex justify-end space-x-3 mb-6">
                        <a href="{{ route('materias.edit', $materia) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> **Editar**
                        </a>
                        <a href="{{ route('materias.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                        </a>
                    </div>

                    <div class="space-y-4">
                        
                        {{-- Sigla --}}
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Sigla:</p>
                            <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $materia->sigla }}</p>
                        </div>
                        
                        {{-- Nombre --}}
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Nombre Completo:</p>
                            <p class="w-2/3 text-base text-white dark:text-white">{{ $materia->nombre }}</p>
                        </div>

                        {{-- Créditos (Comentado en original)
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Créditos:</p>
                            <p class="w-2/3 text-base text-yellow-400 font-bold">{{ $materia->creditos }}</p>
                        </div> --}}

                        {{-- Carga Horaria (Comentado en original)
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Carga Horaria:</p>
                            <p class="w-2/3 text-base text-white">{{ $materia->carga_horaria }} Horas/Semana</p>
                        </div> --}}

                        {{-- Descripción --}}
                        <div class="pt-4 border-t border-gray-700 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-400 mb-2">Descripción / Contenido:</p>
                            <div class="bg-gray-700/50 p-4 rounded-md text-gray-300 dark:text-gray-300 whitespace-pre-wrap">
                                {{ $materia->descripcion ?? 'No se proporcionó una descripción.' }}
                            </div>
                        </div>
                    </div>

                    {{-- Metadatos --}}
                    <div class="mt-8 pt-4 border-t border-gray-700 dark:border-gray-700 text-xs text-gray-500">
                        <p>Registro Creado: **{{ $materia->created_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $materia->created_at->diffForHumans() }})</p>
                        <p>Última Actualización: **{{ $materia->updated_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $materia->updated_at->diffForHumans() }})</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>