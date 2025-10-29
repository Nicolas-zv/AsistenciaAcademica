{{-- resources/views/permisos/create.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Nuevo Permiso
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Crear Nuevo Permiso
                </h1>

                {{-- Manejo de Errores --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-200 bg-red-900/70 rounded-lg border border-red-700 dark:bg-red-900/70 dark:border-red-700">
                        <p class="font-bold mb-1">Por favor, corrija los siguientes errores:</p>
                        <ul class="list-disc list-inside ml-4">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('permisos.store') }}" 
                      class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-lg mx-auto">
                    @csrf

                    {{-- Nombre del Permiso --}}
                    <div class="mb-5">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre del Permiso <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required 
                               class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                               autofocus>
                        @error('nombre')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-6">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción (Opcional)</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                                  class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-end space-x-3 border-t border-gray-700 dark:border-gray-700 pt-6">
                        <a href="{{ route('permisos.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            **Cancelar**
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                            **Guardar Permiso**
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>