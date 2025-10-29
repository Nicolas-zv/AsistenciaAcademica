{{-- resources/views/permisos/show.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle del Permiso
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Detalle del Permiso: <span class="text-white dark:text-white">{{ $permiso->nombre }}</span>
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-lg mx-auto">
                    
                    <div class="space-y-4">
                        
                        {{-- ID --}}
                        <div class="mb-4 border-b border-gray-700 dark:border-gray-700 pb-2">
                            <p class="text-sm font-medium text-gray-400">ID del Permiso:</p>
                            <p class="text-lg text-white dark:text-white font-semibold">{{ $permiso->id }}</p>
                        </div>
                        
                        {{-- Nombre --}}
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-400">Nombre:</p>
                            <p class="text-lg text-white dark:text-white">{{ $permiso->nombre }}</p>
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-400">Descripción:</p>
                            <div class="bg-gray-700/50 p-3 rounded-md text-gray-300 whitespace-pre-wrap">
                                {{ $permiso->descripcion ?? 'Sin descripción.' }}
                            </div>
                        </div>
                    </div>

                    {{-- Metadatos --}}
                    <div class="text-sm text-gray-500 border-t border-gray-700 dark:border-gray-700 pt-4 mt-4">
                        <p>Creado el: **{{ $permiso->created_at->format('d/m/Y H:i') }}** ({{ $permiso->created_at->diffForHumans() }})</p>
                        <p>Actualizado el: **{{ $permiso->updated_at->format('d/m/Y H:i') }}** ({{ $permiso->updated_at->diffForHumans() }})</p>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-start mt-6 space-x-3">
                        <a href="{{ route('permisos.edit', $permiso) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> **Editar**
                        </a>
                        <a href="{{ route('permisos.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>