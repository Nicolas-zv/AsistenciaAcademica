@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Crear Nuevo Permiso
        </h1>

        @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-200 bg-red-900/70 rounded-lg border border-red-700">
                <p class="font-bold mb-1">Por favor, corrija los siguientes errores:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('permisos.store') }}" 
              class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-lg">
            @csrf

            <div class="mb-5">
                <label for="nombre" class="block text-sm font-medium text-gray-300 mb-1">Nombre del Permiso <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required 
                       class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-1">Descripción (Opcional)</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('permisos.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150">
                    Guardar Permiso
                </button>
            </div>
        </form>
    </div>
@endsection