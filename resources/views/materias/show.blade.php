@extends('layouts.app')

@section('header', 'Detalle de Materia')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Detalle de Materia: {{ $materia->nombre }}
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
            
            <div class="flex justify-end space-x-3 mb-6">
                <a href="{{ route('materias.edit', $materia) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Editar
                </a>
                <a href="{{ route('materias.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                </a>
            </div>

            <div class="space-y-4">
                
                {{-- Código --}}
                <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Sigla:</p>
                    <p class="w-2/3 text-base text-white font-bold">{{ $materia->sigla }}</p>
                </div>
                
                {{-- Nombre --}}
                <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Nombre Completo:</p>
                    <p class="w-2/3 text-base text-white">{{ $materia->nombre }}</p>
                </div>

                {{-- Créditos
                <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Créditos:</p>
                    <p class="w-2/3 text-base text-yellow-400 font-bold">{{ $materia->creditos }}</p>
                </div>

                {{-- Carga Horaria --}}
                {{-- <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Carga Horaria:</p>
                    <p class="w-2/3 text-base text-white">{{ $materia->carga_horaria }} Horas/Semana</p>
                </div>  --}}

                {{-- Descripción --}}
                <div class="pt-4 border-t border-gray-700">
                    <p class="text-sm font-medium text-gray-400 mb-2">Descripción / Contenido:</p>
                    <div class="bg-gray-700/50 p-4 rounded-md text-gray-300 whitespace-pre-wrap">
                        {{ $materia->descripcion ?? 'No se proporcionó una descripción.' }}
                    </div>
                </div>
            </div>

            {{-- Metadatos --}}
            <div class="mt-8 pt-4 border-t border-gray-700 text-xs text-gray-500">
                <p>Registro Creado: {{ $materia->created_at->diffForHumans() }} ({{ $materia->created_at->format('d/m/Y H:i') }})</p>
                <p>Última Actualización: {{ $materia->updated_at->diffForHumans() }} ({{ $materia->updated_at->format('d/m/Y H:i') }})</p>
            </div>
            
        </div>
    </div>
@endsection