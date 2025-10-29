{{-- resources/views/horarios/create.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Programar Nuevo Horario
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-white dark:text-white mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Programar Nuevo Horario
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto">
                    
                    <form action="{{ route('horarios.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            
                            {{-- Grupo-Materia (Asignación) --}}
                            <div>
                                <label for="grupo_materia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asignación Grupo-Materia (*)</label>
                                <select name="grupo_materia_id" id="grupo_materia_id" required
                                        class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('grupo_materia_id') border-red-500 @enderror">
                                    <option value="">-- Seleccione Materia y Grupo --</option>
                                    @foreach($grupoMaterias as $gm)
                                        <option value="{{ $gm['id'] }}" {{ old('grupo_materia_id') == $gm['id'] ? 'selected' : '' }}>
                                            {{ $gm['nombre_completo'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('grupo_materia_id')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            {{-- Día, Hora Inicio, Hora Fin --}}
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="dia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Día (*)</label>
                                    <select name="dia" id="dia" required
                                            class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('dia') border-red-500 @enderror">
                                        <option value="">-- Día --</option>
                                        @foreach($dias as $num => $nombre)
                                            <option value="{{ $num }}" {{ old('dia') == (string)$num ? 'selected' : '' }}>
                                                {{ $nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dia')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="hora_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora Inicio (*)</label>
                                    <input type="time" name="hora_inicio" id="hora_inicio" required
                                           class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('hora_inicio') border-red-500 @enderror" 
                                           value="{{ old('hora_inicio') }}">
                                    @error('hora_inicio')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="hora_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora Fin (*)</label>
                                    <input type="time" name="hora_fin" id="hora_fin" required
                                           class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('hora_fin') border-red-500 @enderror" 
                                           value="{{ old('hora_fin') }}">
                                    @error('hora_fin')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Modalidad y Estado --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="modalidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modalidad</label>
                                    <select name="modalidad" id="modalidad"
                                            class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('modalidad') border-red-500 @enderror">
                                        <option value="" {{ old('modalidad') == '' ? 'selected' : '' }}>-- Sin especificar --</option>
                                        <option value="Presencial" {{ old('modalidad') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                        <option value="Virtual" {{ old('modalidad') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                        <option value="Híbrido" {{ old('modalidad') == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                                    </select>
                                    @error('modalidad')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado (*)</label>
                                    <select name="estado" id="estado" required
                                            class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('estado') border-red-500 @enderror">
                                        <option value="programado" {{ old('estado', 'programado') == 'programado' ? 'selected' : '' }}>Programado</option>
                                        <option value="vigente" {{ old('estado') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                                        <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('estado')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-8 flex justify-end space-x-4 border-t border-gray-700 dark:border-gray-700 pt-6">
                            <a href="{{ route('horarios.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                                **Cancelar**
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                                <i class="fa-solid fa-save mr-2"></i> **Guardar Horario**
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>