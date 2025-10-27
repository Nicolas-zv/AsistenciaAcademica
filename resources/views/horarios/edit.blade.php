@extends('layouts.app')

@section('header', 'Editar Horario')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-gray-700 pb-3">
            Editar Horario para {{ $horario->grupoMateria->materia->sigla ?? 'N/A' }}
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
            
            <form action="{{ route('horarios.update', $horario) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    {{-- Grupo-Materia --}}
                    <div>
                        <label for="grupo_materia_id" class="block text-sm font-medium text-gray-300 mb-1">Asignación Grupo-Materia (*)</label>
                        <select name="grupo_materia_id" id="grupo_materia_id" required
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('grupo_materia_id') border-red-500 @enderror">
                            <option value="">-- Seleccione Materia y Grupo --</option>
                            @foreach($grupoMaterias as $gm)
                                <option value="{{ $gm['id'] }}" {{ old('grupo_materia_id', $horario->grupo_materia_id) == $gm['id'] ? 'selected' : '' }}>
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
                            <label for="dia" class="block text-sm font-medium text-gray-300 mb-1">Día (*)</label>
                            <select name="dia" id="dia" required
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('dia') border-red-500 @enderror">
                                <option value="">-- Día --</option>
                                @foreach($dias as $num => $nombre)
                                    <option value="{{ $num }}" {{ old('dia', $horario->dia) == (string)$num ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dia')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="hora_inicio" class="block text-sm font-medium text-gray-300 mb-1">Hora Inicio (*)</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" required
                                   class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('hora_inicio') border-red-500 @enderror" 
                                   value="{{ old('hora_inicio', $horario->hora_inicio) }}">
                            @error('hora_inicio')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="hora_fin" class="block text-sm font-medium text-gray-300 mb-1">Hora Fin (*)</label>
                            <input type="time" name="hora_fin" id="hora_fin" required
                                   class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('hora_fin') border-red-500 @enderror" 
                                   value="{{ old('hora_fin', $horario->hora_fin) }}">
                            @error('hora_fin')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Modalidad y Estado --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="modalidad" class="block text-sm font-medium text-gray-300 mb-1">Modalidad</label>
                            <select name="modalidad" id="modalidad"
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('modalidad') border-red-500 @enderror">
                                <option value="" {{ old('modalidad', $horario->modalidad) == '' ? 'selected' : '' }}>-- Sin especificar --</option>
                                <option value="Presencial" {{ old('modalidad', $horario->modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="Virtual" {{ old('modalidad', $horario->modalidad) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                <option value="Híbrido" {{ old('modalidad', $horario->modalidad) == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                            </select>
                            @error('modalidad')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-300 mb-1">Estado (*)</label>
                            <select name="estado" id="estado" required
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('estado') border-red-500 @enderror">
                                <option value="programado" {{ old('estado', $horario->estado) == 'programado' ? 'selected' : '' }}>Programado</option>
                                <option value="vigente" {{ old('estado', $horario->estado) == 'vigente' ? 'selected' : '' }}>Vigente</option>
                                <option value="cancelado" {{ old('estado', $horario->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('estado')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('horarios.show', $horario) }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-save mr-2"></i> Actualizar Horario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection