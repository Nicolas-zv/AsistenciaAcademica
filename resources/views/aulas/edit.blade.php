{{-- resources/views/aulas/edit.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Aula
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">
                
                <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-6 border-b border-gray-700 pb-3">
                    Editar Aula: **{{ $aula->numero }}**
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
                    
                    <form action="{{ route('aulas.update', $aula) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            
                            {{-- Número de Aula y Módulo --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="numero" class="block text-sm font-medium text-gray-300 mb-1">Número de Aula (*)</label>
                                    <input type="text" name="numero" id="numero" 
                                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('numero') border-red-500 @enderror" 
                                            value="{{ old('numero', $aula->numero) }}" required autofocus>
                                    @error('numero')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="modulo_id" class="block text-sm font-medium text-gray-300 mb-1">Módulo/Edificio</label>
                                    <select name="modulo_id" id="modulo_id"
                                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('modulo_id') border-red-500 @enderror">
                                        <option value="">-- Seleccione Módulo --</option>
                                        @foreach($modulos as $modulo)
                                            <option value="{{ $modulo->id }}" {{ old('modulo_id', $aula->modulo_id) == $modulo->id ? 'selected' : '' }}>
                                                {{ $modulo->nombre }} ({{ $modulo->codigo ?? 'N/C' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('modulo_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- Tipo y Capacidad --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tipo" class="block text-sm font-medium text-gray-300 mb-1">Tipo de Aula</label>
                                    <select name="tipo" id="tipo"
                                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('tipo') border-red-500 @enderror">
                                        <option value="">-- Seleccione Tipo --</option>
                                        <option value="Aula Teórica" {{ old('tipo', $aula->tipo) == 'Aula Teórica' ? 'selected' : '' }}>Aula Teórica</option>
                                        <option value="Laboratorio" {{ old('tipo', $aula->tipo) == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                                        <option value="Aula Taller" {{ old('tipo', $aula->tipo) == 'Aula Taller' ? 'selected' : '' }}>Aula Taller</option>
                                        <option value="Auditorio" {{ old('tipo', $aula->tipo) == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
                                        <option value="Oficina" {{ old('tipo', $aula->tipo) == 'Oficina' ? 'selected' : '' }}>Oficina</option>
                                    </select>
                                    @error('tipo')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="capacidad" class="block text-sm font-medium text-gray-300 mb-1">Capacidad (Personas)</label>
                                    <input type="number" name="capacidad" id="capacidad" min="1"
                                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('capacidad') border-red-500 @enderror" 
                                            value="{{ old('capacidad', $aula->capacidad) }}">
                                    @error('capacidad')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Ubicación --}}
                            <div>
                                <label for="ubicacion" class="block text-sm font-medium text-gray-300 mb-1">Ubicación / Referencia</label>
                                <textarea name="ubicacion" id="ubicacion" rows="2"
                                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('ubicacion') border-red-500 @enderror">{{ old('ubicacion', $aula->ubicacion) }}</textarea>
                                @error('ubicacion')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('aulas.show', $aula) }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                                <i class="fa-solid fa-save mr-2"></i> Actualizar Aula
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>