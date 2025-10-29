{{-- resources/views/grupo_materia/create.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Nueva Asignación
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-white mb-6 border-b border-gray-700 pb-3">
                    Crear Nueva Asignación **Grupo-Materia-Gestión**
                </h1>

                <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-4xl mx-auto">
                    
                    <form action="{{ route('grupo_materia.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            
                            {{-- Bloque 1: Identificación (Materia, Grupo, Gestión) --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-700 pb-6">
                                <h2 class="col-span-full text-lg font-semibold text-indigo-400 mb-2">Identificación Académica (*)</h2>
                                
                                {{-- Materia --}}
                                <div>
                                    <label for="materia_id" class="block text-sm font-medium text-gray-300 mb-1">Materia (*)</label>
                                    <select name="materia_id" id="materia_id" required
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('materia_id') border-red-500 @enderror">
                                        <option value="">-- Seleccione Materia --</option>
                                        @foreach($materias as $materia)
                                            <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                                {{ $materia->sigla }} - {{ $materia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('materia_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                {{-- Grupo --}}
                                <div>
                                    <label for="grupo_id" class="block text-sm font-medium text-gray-300 mb-1">Grupo (*)</label>
                                    <select name="grupo_id" id="grupo_id" required
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('grupo_id') border-red-500 @enderror">
                                        <option value="">-- Seleccione Grupo --</option>
                                        @foreach($grupos as $grupo)
                                            <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                                {{ $grupo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('grupo_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                {{-- Gestión --}}
                                <div>
                                    <label for="gestion_id" class="block text-sm font-medium text-gray-300 mb-1">Gestión (*)</label>
                                    <select name="gestion_id" id="gestion_id" required
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('gestion_id') border-red-500 @enderror">
                                        <option value="">-- Seleccione Gestión --</option>
                                        @foreach($gestiones as $gestion)
                                            <option value="{{ $gestion->id }}" {{ old('gestion_id') == $gestion->id ? 'selected' : '' }}>
                                                {{ $gestion->año }} - {{ $gestion->semestre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gestion_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Bloque 2: Detalles y Ubicación (Incluyendo Docente) --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-700 pb-6">
                                <h2 class="col-span-full text-lg font-semibold text-gray-300 mb-2">Detalles, Ubicación y Docente</h2>

                                {{-- Docente Asignado --}}
                                <div class="md:col-span-3">
                                    <label for="docente_id" class="block text-sm font-medium text-gray-300 mb-1">Docente Asignado</label>
                                    <select name="docente_id" id="docente_id"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('docente_id') border-red-500 @enderror">
                                        <option value="">-- Sin Docente Asignado --</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                                {{ $docente->user->nombre ?? 'Docente ID: ' . $docente->id }} ({{ $docente->codigo }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('docente_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Módulo Asignado --}}
                                <div>
                                    <label for="modulo_id" class="block text-sm font-medium text-gray-300 mb-1">Módulo Asignado</label>
                                    <select name="modulo_id" id="modulo_id"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('modulo_id') border-red-500 @enderror">
                                        <option value="">-- Sin Módulo --</option>
                                        @foreach($modulos as $modulo)
                                            <option value="{{ $modulo->id }}" {{ old('modulo_id') == $modulo->id ? 'selected' : '' }}>
                                                {{ $modulo->nombre }} ({{ $modulo->codigo ?? 'N/C' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('modulo_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                {{-- Aula Asignada --}}
                                <div>
                                    <label for="aula_id" class="block text-sm font-medium text-gray-300 mb-1">Aula Asignada</label>
                                    <select name="aula_id" id="aula_id"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('aula_id') border-red-500 @enderror">
                                        <option value="">-- Sin Aula --</option>
                                        @foreach($aulas as $aula)
                                            <option value="{{ $aula->id }}" {{ old('aula_id') == $aula->id ? 'selected' : '' }}>
                                                N° {{ $aula->numero }} ({{ $aula->modulo->codigo ?? 'M.N/A' }}) - {{ $aula->tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aula_id')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Turno --}}
                                <div>
                                    <label for="turno" class="block text-sm font-medium text-gray-300 mb-1">Turno</label>
                                    <select name="turno" id="turno"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('turno') border-red-500 @enderror">
                                        <option value="" {{ old('turno') == '' ? 'selected' : '' }}>-- Seleccione --</option>
                                        <option value="Mañana" {{ old('turno') == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                                        <option value="Tarde" {{ old('turno') == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                        <option value="Noche" {{ old('turno') == 'Noche' ? 'selected' : '' }}>Noche</option>
                                    </select>
                                    @error('turno')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Cupo --}}
                                <div>
                                    <label for="cupo" class="block text-sm font-medium text-gray-300 mb-1">Cupo Máximo</label>
                                    <input type="number" name="cupo" id="cupo" min="1"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('cupo') border-red-500 @enderror" 
                                        value="{{ old('cupo') }}">
                                    @error('cupo')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Estado --}}
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-300 mb-1">Estado (*)</label>
                                    <select name="estado" id="estado" required
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('estado') border-red-500 @enderror">
                                        <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo (En espera)</option>
                                        <option value="cerrado" {{ old('estado') == 'cerrado' ? 'selected' : '' }}>Cerrado (Finalizado)</option>
                                    </select>
                                    @error('estado')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-8 flex justify-end space-x-4 border-t border-gray-700 pt-6">
                            <a href="{{ route('grupo_materia.index') }}" 
                                class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                                <i class="fa-solid fa-save mr-2"></i> Guardar Asignación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>