@extends('layouts.app')

@section('header', 'Crear Nueva Aula')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-gray-700 pb-3">
            Registrar Nueva Aula
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
            
            <form action="{{ route('aulas.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    
                    {{-- Número de Aula y Módulo --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="numero" class="block text-sm font-medium text-gray-300 mb-1">Número de Aula (*)</label>
                            <input type="text" name="numero" id="numero" 
                                   class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('numero') border-red-500 @enderror" 
                                   value="{{ old('numero') }}" required autofocus>
                            @error('numero')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="modulo_id" class="block text-sm font-medium text-gray-300 mb-1">Módulo/Edificio</label>
                            <select name="modulo_id" id="modulo_id"
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('modulo_id') border-red-500 @enderror">
                                <option value="" {{ old('modulo_id') == '' ? 'selected' : '' }}>-- Seleccione Módulo --</option>
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
                    </div>
                    
                    {{-- Tipo y Capacidad --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-300 mb-1">Tipo de Aula</label>
                            <select name="tipo" id="tipo"
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('tipo') border-red-500 @enderror">
                                <option value="" {{ old('tipo') == '' ? 'selected' : '' }}>-- Seleccione Tipo --</option>
                                <option value="Aula Teórica" {{ old('tipo') == 'Aula Teórica' ? 'selected' : '' }}>Aula Teórica</option>
                                <option value="Laboratorio" {{ old('tipo') == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                                <option value="Aula Taller" {{ old('tipo') == 'Aula Taller' ? 'selected' : '' }}>Aula Taller</option>
                                <option value="Auditorio" {{ old('tipo') == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
                                <option value="Oficina" {{ old('tipo') == 'Oficina' ? 'selected' : '' }}>Oficina</option>
                            </select>
                            @error('tipo')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="capacidad" class="block text-sm font-medium text-gray-300 mb-1">Capacidad (Personas)</label>
                            <input type="number" name="capacidad" id="capacidad" min="1"
                                   class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('capacidad') border-red-500 @enderror" 
                                   value="{{ old('capacidad') }}">
                            @error('capacidad')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Ubicación --}}
                    <div>
                        <label for="ubicacion" class="block text-sm font-medium text-gray-300 mb-1">Ubicación / Referencia</label>
                        <textarea name="ubicacion" id="ubicacion" rows="2"
                                  class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('ubicacion') border-red-500 @enderror">{{ old('ubicacion') }}</textarea>
                        @error('ubicacion')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Botones de Acción --}}
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('aulas.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-save mr-2"></i> Guardar Aula
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection