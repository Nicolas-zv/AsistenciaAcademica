@extends('layouts.app')

@section('header', 'Detalle de Aula')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Detalle del Aula N° {{ $aula->numero }}
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-3xl mx-auto">
            
            <div class="flex justify-end space-x-3 mb-6">
                <a href="{{ route('aulas.edit', $aula) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Editar
                </a>
                <a href="{{ route('aulas.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                </a>
            </div>

            <div class="space-y-4">
                
                {{-- Número --}}
                <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Número de Aula:</p>
                    <p class="w-2/3 text-base text-white font-bold">{{ $aula->numero }}</p>
                </div>
                
                {{-- Módulo --}}
                <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Módulo/Edificio:</p>
                    <p class="w-2/3 text-base text-indigo-400">
                        {{ $aula->modulo->nombre ?? 'N/A' }} 
                        @if($aula->modulo)
                            <span class="text-gray-500 text-sm">({{ $aula->modulo->codigo }})</span>
                        @endif
                    </p>
                </div>

                {{-- Tipo --}}
                <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Tipo de Aula:</p>
                    <p class="w-2/3 text-base text-gray-300">{{ $aula->tipo ?? 'No especificado' }}</p>
                </div>
                
                {{-- Capacidad --}}
                <div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">Capacidad:</p>
                    <p class="w-2/3 text-base text-gray-300">{{ $aula->capacidad ?? 'N/A' }} personas</p>
                </div>
                
                {{-- Ubicación --}}
                <div class="pt-4 border-t border-gray-700">
                    <p class="text-sm font-medium text-gray-400 mb-2">Ubicación / Referencia:</p>
                    <div class="bg-gray-700/50 p-4 rounded-md text-gray-300 whitespace-pre-wrap">
                        {{ $aula->ubicacion ?? 'No se proporcionó una ubicación detallada.' }}
                    </div>
                </div>
            </div>

            {{-- Metadatos --}}
            <div class="mt-8 pt-4 border-t border-gray-700 text-xs text-gray-500">
                <p>Registro Creado: {{ $aula->created_at->diffForHumans() }}</p>
                <p>Última Actualización: {{ $aula->updated_at->diffForHumans() }}</p>
            </div>
            
        </div>
    </div>
@endsection