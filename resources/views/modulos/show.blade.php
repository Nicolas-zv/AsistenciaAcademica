{{-- resources/views/modulos/show.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle de Módulo
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Detalle del Módulo: <span class="text-white dark:text-white">{{ $modulo->nombre }}</span>
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto">
                    
                    {{-- Botones de Acción --}}
                    <div class="flex justify-end space-x-3 mb-6">
                        <a href="{{ route('modulos.edit', $modulo) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> **Editar**
                        </a>
                        <a href="{{ route('modulos.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                        </a>
                    </div>

                    <div class="space-y-4">
                        
                        {{-- Nombre --}}
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Nombre:</p>
                            <p class="w-2/3 text-base text-white dark:text-white font-bold">{{ $modulo->nombre }}</p>
                        </div>
                        
                        {{-- Código --}}
                        <div class="flex items-start">
                            <p class="w-1/3 text-sm font-medium text-gray-400">Código:</p>
                            <p class="w-2/3 text-base text-indigo-400 dark:text-indigo-400 font-bold">{{ $modulo->codigo ?? 'N/A' }}</p>
                        </div>

                    </div>

                    {{-- Metadatos --}}
                    <div class="mt-8 pt-4 border-t border-gray-700 dark:border-gray-700 text-xs text-gray-500">
                        <p>Registro Creado: **{{ $modulo->created_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $modulo->created_at->diffForHumans() }})</p>
                        <p>Última Actualización: **{{ $modulo->updated_at->isoFormat('D MMMM YYYY, h:mm a') }}** ({{ $modulo->updated_at->diffForHumans() }})</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>