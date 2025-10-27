@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Registrar Nuevo Docente
        </h1>

        <form method="POST" action="{{ route('docentes.store') }}" 
              class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-2xl">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label for="user_id" class="block text-sm font-medium text-gray-300 mb-1">Usuario a Vincular <span class="text-red-500">*</span></label>
                    <select name="user_id" id="user_id" required 
                            class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('user_id') border-red-500 @enderror">
                        <option value="">-- Seleccione un usuario --</option>
                        @foreach ($usuariosDisponibles as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->nombre }} ({{ $user->correo }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-300 mb-1">Código Docente (Opcional)</label>
                    <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" 
                           class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('codigo') border-red-500 @enderror">
                    @error('codigo')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_contrato" class="block text-sm font-medium text-gray-300 mb-1">Fecha Contrato (Opcional)</label>
                    <input type="date" name="fecha_contrato" id="fecha_contrato" value="{{ old('fecha_contrato') }}" 
                           class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_contrato') border-red-500 @enderror">
                    @error('fecha_contrato')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="carga_horaria" class="block text-sm font-medium text-gray-300 mb-1">Carga Horaria (Hrs/Sem) <span class="text-red-500">*</span></label>
                    <input type="number" name="carga_horaria" id="carga_horaria" value="{{ old('carga_horaria', 0) }}" required min="0" 
                           class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('carga_horaria') border-red-500 @enderror">
                    @error('carga_horaria')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="especialidad" class="block text-sm font-medium text-gray-300 mb-1">Especialidad (Opcional)</label>
                    <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad') }}" 
                           class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('especialidad') border-red-500 @enderror">
                    @error('especialidad')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="categoria" class="block text-sm font-medium text-gray-300 mb-1">Categoría (Opcional)</label>
                    <select name="categoria" id="categoria" 
                            class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('categoria') border-red-500 @enderror">
                        <option value="">-- Seleccione Categoría --</option>
                        <option value="Titular" {{ old('categoria') == 'Titular' ? 'selected' : '' }}>Titular</option>
                        <option value="Interino" {{ old('categoria') == 'Interino' ? 'selected' : '' }}>Interino</option>
                        <option value="Invitado" {{ old('categoria') == 'Invitado' ? 'selected' : '' }}>Invitado</option>
                        <option value="Asistente" {{ old('categoria') == 'Asistente' ? 'selected' : '' }}>Asistente</option>
                    </select>
                    @error('categoria')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <div class="flex justify-end space-x-3 mt-8 border-t border-gray-700 pt-6">
                <a href="{{ route('docentes.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150">
                    Guardar Docente
                </button>
            </div>
        </form>
    </div>
@endsection