@extends('layouts.app')

@section('header', 'Editar Gestión')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-gray-700 pb-3">
            Editar Gestión: {{ $gestion->año }}@if($gestion->semestre)-{{ $gestion->semestre }}@endif
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
            
            <form action="{{ route('gestion.update', $gestion) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    {{-- Año y Semestre (en una fila) --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="año" class="block text-sm font-medium text-gray-300 mb-1">Año (*)</label>
                            <input type="number" name="año" id="año" min="2000" max="{{ date('Y') + 1 }}" 
                                   class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('año') border-red-500 @enderror" 
                                   value="{{ old('año', $gestion->año) }}" required>
                            @error('año')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="semestre" class="block text-sm font-medium text-gray-300 mb-1">Semestre</label>
                            <select name="semestre" id="semestre"
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('semestre') border-red-500 @enderror">
                                <option value="" {{ old('semestre', $gestion->semestre) == '' ? 'selected' : '' }}>-- No Aplica --</option>
                                <option value="I" {{ old('semestre', $gestion->semestre) == 'I' ? 'selected' : '' }}>I</option>
                                <option value="II" {{ old('semestre', $gestion->semestre) == 'II' ? 'selected' : '' }}>II</option>
                                <option value="Verano" {{ old('semestre', $gestion->semestre) == 'Verano' ? 'selected' : '' }}>Verano</option>
                            </select>
                            @error('semestre')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Estado --}}
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-300 mb-1">Estado (*)</label>
                        <select name="estado" id="estado" required
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('estado') border-red-500 @enderror">
                            <option value="inactiva" {{ old('estado', $gestion->estado) == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                            <option value="activa" {{ old('estado', $gestion->estado) == 'activa' ? 'selected' : '' }}>Activa (Si se selecciona, se desactivarán las demás)</option>
                        </select>
                        @error('estado')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-1">Descripción / Notas</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                                  class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $gestion->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Botones de Acción --}}
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('gestion.show', $gestion) }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-save mr-2"></i> Actualizar Gestión
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection