{{-- resources/views/modulos/create.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Nuevo Módulo
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-white dark:text-white mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Registrar Nuevo Módulo
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto">
                    
                    <form action="{{ route('modulos.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            
                            {{-- Nombre --}}
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre del Módulo (*)</label>
                                <input type="text" name="nombre" id="nombre" 
                                       class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-500 @enderror" 
                                       value="{{ old('nombre') }}" required autofocus>
                                @error('nombre')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Código --}}
                            <div>
                                <label for="codigo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código (Opcional, debe ser único)</label>
                                <input type="text" name="codigo" id="codigo" 
                                       class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('codigo') border-red-500 @enderror" 
                                       value="{{ old('codigo') }}">
                                @error('codigo')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-8 flex justify-end space-x-4 border-t border-gray-700 dark:border-gray-700 pt-6">
                            <a href="{{ route('modulos.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                                **Cancelar**
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                                <i class="fa-solid fa-save mr-2"></i> **Guardar Módulo**
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>