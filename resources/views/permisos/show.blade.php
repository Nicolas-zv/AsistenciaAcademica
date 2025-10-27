@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Detalle del Permiso
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-lg">
            
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-400">ID del Permiso:</p>
                <p class="text-lg text-white font-semibold">{{ $permiso->id }}</p>
            </div>
            
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-400">Nombre:</p>
                <p class="text-lg text-white">{{ $permiso->nombre }}</p>
            </div>

            <div class="mb-6">
                <p class="text-sm font-medium text-gray-400">Descripción:</p>
                <p class="text-lg text-white break-words">{{ $permiso->descripcion ?? 'Sin descripción.' }}</p>
            </div>

            <div class="text-sm text-gray-500 border-t border-gray-700 pt-4 mt-4">
                <p>Creado el: {{ $permiso->created_at->format('d/m/Y H:i') }}</p>
                <p>Actualizado el: {{ $permiso->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <div class="flex justify-start mt-6 space-x-3">
                <a href="{{ route('permisos.edit', $permiso) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150">
                    Editar
                </a>
                <a href="{{ route('permisos.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>
@endsection