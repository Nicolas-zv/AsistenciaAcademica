@extends('layouts.app')

@section('header', 'Editar Grupo')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-gray-700 pb-3">
            Editar Grupo: {{ $grupo->nombre }}
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
            
            <form action="{{ route('grupos.update', $grupo) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-300 mb-1">Nombre del Grupo (*)</label>
                        <input type="text" name="nombre" id="nombre" 
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-500 @enderror" 
                               value="{{ old('nombre', $grupo->nombre) }}" required autofocus>
                        @error('nombre')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-1">Descripción / Notas</label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                                  class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $grupo->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Botones de Acción --}}
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('grupos.show', $grupo) }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-save mr-2"></i> Actualizar Grupo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection