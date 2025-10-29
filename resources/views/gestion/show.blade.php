{{-- resources/views/gestion/show.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle de Gestión
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-white mb-6 border-b border-gray-700 pb-3">
                    Gestión **{{ $gestion->año }}@if($gestion->semestre)-{{ $gestion->semestre }}@endif**
                </h1>

                <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
                    
                    <div class="flex justify-end space-x-3 mb-6">
                        <a href="{{ route('gestion.edit', $gestion) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> Editar
                        </a>
                        <a href="{{ route('gestion.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                        </a>
                    </div>

                    <div class="space-y-4">
                        
                        {{-- Año --}}
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Año:</p>
                            <p class="w-2/3 text-base text-white font-bold">{{ $gestion->año }}</p>
                        </div>
                        
                        {{-- Semestre --}}
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Semestre:</p>
                            <p class="w-2/3 text-base text-white">{{ $gestion->semestre ?? 'N/A' }}</p>
                        </div>

                        {{-- Estado --}}
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Estado Actual:</p>
                            <p class="w-2/3 text-base text-white">
                                @if ($gestion->estado == 'activa')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-800 text-green-100">
                                        <i class="fa-solid fa-circle-check mr-2"></i> ACTIVA (Gestión en Curso)
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-700 text-gray-300">
                                        INACTIVA
                                    </span>
                                @endif
                            </p>
                        </div>

                        {{-- Descripción --}}
                        <div class="pt-4 border-t border-gray-700">
                            <p class="text-sm font-medium text-gray-400 mb-2">Descripción / Notas:</p>
                            <div class="bg-gray-700/50 p-4 rounded-md text-gray-300 whitespace-pre-wrap">
                                {{ $gestion->descripcion ?? 'No se proporcionó una descripción.' }}
                            </div>
                        </div>
                    </div>

                    {{-- Metadatos --}}
                    <div class="mt-8 pt-4 border-t border-gray-700 text-xs text-gray-500 space-y-1">
                        <p>Registro Creado: {{ $gestion->created_at->diffForHumans() }} (<span class="text-gray-400">{{ $gestion->created_at->format('d/m/Y H:i') }}</span>)</p>
                        <p>Última Actualización: {{ $gestion->updated_at->diffForHumans() }} (<span class="text-gray-400">{{ $gestion->updated_at->format('d/m/Y H:i') }}</span>)</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>