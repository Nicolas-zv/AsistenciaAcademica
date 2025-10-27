@extends('layouts.app')

@section('header', 'Editar Asignación')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-gray-700 pb-3">
            Editar Asignación: {{ $grupoMateria->materia->sigla ?? 'N/A' }}-{{ $grupoMateria->grupo->nombre ?? 'N/A' }}
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-4xl mx-auto">
            
            <form action="{{ route('grupo_materia.update', ['grupoMateria' => $grupoMateria]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    {{-- Bloque 1: Identificación (Materia, Grupo, Gestión) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-gray-700 pb-6">
                        <h2 class="col-span-full text-lg font-semibold text-indigo-400 mb-2">Identificación Académica (*)</h2>
                        <p class="col-span-full text-sm text-yellow-400 mb-2"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Cambiar esta combinación (Materia/Grupo/Gestión) puede afectar la unicidad.</p>

                        <div>
                            <label for="materia_id" class="block text-sm font-medium text-gray-300 mb-1">Materia (*)</label>
                            <select name="materia_id" id="materia_id" required
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('materia_id') border-red-500 @enderror">
                                <option value="">-- Seleccione Materia --</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" {{ old('materia_id', $grupoMateria->materia_id) == $materia->id ? 'selected' : '' }}>
                                        {{ $materia->sigla }} - {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('materia_id')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="grupo_id" class="block text-sm font-medium text-gray-300 mb-1">Grupo (*)</label>
                            <select name="grupo_id" id="grupo_id" required
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('grupo_id') border-red-500 @enderror">
                                <option value="">-- Seleccione Grupo --</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ old('grupo_id', $grupoMateria->grupo_id) == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grupo_id')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="gestion_id" class="block text-sm font-medium text-gray-300 mb-1">Gestión (*)</label>
                            <select name="gestion_id" id="gestion_id" required
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('gestion_id') border-red-500 @enderror">
                                <option value="">-- Seleccione Gestión --</option>
                                @foreach($gestiones as $gestion)
                                    <option value="{{ $gestion->id }}" {{ old('gestion_id', $grupoMateria->gestion_id) == $gestion->id ? 'selected' : '' }}>
                                        {{ $gestion->año }} - {{ $gestion->semestre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gestion_id')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Bloque 2: Detalles y Ubicación --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-b border-gray-700 pb-6">
                        <h2 class="col-span-full text-lg font-semibold text-gray-300 mb-2">Detalles y Ubicación</h2>

                        {{-- Turno --}}
                        <div>
                            <label for="turno" class="block text-sm font-medium text-gray-300 mb-1">Turno</label>
                            <select name="turno" id="turno"
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('turno') border-red-500 @enderror">
                                <option value="" {{ old('turno', $grupoMateria->turno) == '' ? 'selected' : '' }}>-- Seleccione --</option>
                                <option value="Mañana" {{ old('turno', $grupoMateria->turno) == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                                <option value="Tarde" {{ old('turno', $grupoMateria->turno) == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="Noche" {{ old('turno', $grupoMateria->turno) == 'Noche' ? 'selected' : '' }}>Noche</option>
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
                                   value="{{ old('cupo', $grupoMateria->cupo) }}">
                            @error('cupo')
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
                                    <option value="{{ $modulo->id }}" {{ old('modulo_id', $grupoMateria->modulo_id) == $modulo->id ? 'selected' : '' }}>
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
                                    <option value="{{ $aula->id }}" {{ old('aula_id', $grupoMateria->aula_id) == $aula->id ? 'selected' : '' }}>
                                        N° {{ $aula->numero }} ({{ $aula->modulo->codigo ?? 'M.N/A' }}) - {{ $aula->tipo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aula_id')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="md:col-span-4">
                            <label for="estado" class="block text-sm font-medium text-gray-300 mb-1">Estado (*)</label>
                            <select name="estado" id="estado" required
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('estado') border-red-500 @enderror">
                                <option value="activo" {{ old('estado', $grupoMateria->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $grupoMateria->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo (En espera)</option>
                                <option value="cerrado" {{ old('estado', $grupoMateria->estado) == 'cerrado' ? 'selected' : '' }}>Cerrado (Finalizado)</option>
                            </select>
                            @error('estado')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('grupo_materia.show', $grupoMateria) }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-save mr-2"></i> Actualizar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection