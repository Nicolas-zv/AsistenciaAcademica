{{-- resources/views/materias/edit.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Materia
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-white dark:text-white mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Editar Materia: <span class="text-indigo-400">{{ $materia->nombre }}</span>
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto">
                    
                    <form action="{{ route('materias.update', $materia) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            
                            {{-- Sigla (Ej. MAT-101) --}}
                            <div>
                                <label for="sigla" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sigla de Materia (*)</label>
                                <input type="text" name="sigla" id="sigla" 
                                       class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('sigla') border-red-500 @enderror" 
                                       value="{{ old('sigla', $materia->sigla) }}" required autofocus>
                                @error('sigla')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nombre --}}
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Completo (*)</label>
                                <input type="text" name="nombre" id="nombre" 
                                       class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-500 @enderror" 
                                       value="{{ old('nombre', $materia->nombre) }}" required>
                                @error('nombre')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Créditos y Carga Horaria (comentado) --}}
                            {{-- <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="creditos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Créditos (*)</label>
                                    <input type="number" name="creditos" id="creditos" min="1" 
                                            class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('creditos') border-red-500 @enderror" 
                                            value="{{ old('creditos', $materia->creditos) }}" required>
                                    @error('creditos')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="carga_horaria" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Carga Horaria (Hrs/Semana) (*)</label>
                                    <input type="number" name="carga_horaria" id="carga_horaria" min="1" 
                                            class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('carga_horaria') border-red-500 @enderror" 
                                            value="{{ old('carga_horaria', $materia->carga_horaria) }}" required>
                                    @error('carga_horaria')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}
                            
                            {{-- Descripción --}}
                            <div>
                                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción / Contenido</label>
                                <textarea name="descripcion" id="descripcion" rows="4"
                                        class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $materia->descripcion) }}</textarea>
                                @error('descripcion')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-8 flex justify-end space-x-4 border-t border-gray-700 dark:border-gray-700 pt-6">
                            <a href="{{ route('materias.show', $materia) }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                                **Cancelar**
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                                <i class="fa-solid fa-save mr-2"></i> **Actualizar Materia**
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>