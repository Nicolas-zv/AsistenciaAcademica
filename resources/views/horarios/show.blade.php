@extends('layouts.app')

@section('header', 'Detalle de Horario')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Horario para {{ $horario->grupoMateria->materia->sigla ?? 'N/A' }}
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-4xl mx-auto">
            
            <div class="flex justify-end space-x-3 mb-6">
                <a href="{{ route('horarios.edit', $horario) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Editar Horario
                </a>
                <a href="{{ route('horarios.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver a Horarios
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Columna 1: Información del Horario --}}
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-gray-300 border-b border-gray-700 pb-2 mb-3">Detalles del Horario</h2>
                    
                    @include('partials.detail-row', ['label' => 'Día', 'value' => $horario->dia_nombre, 'subvalue' => 'Día ' . $horario->dia])
                    @include('partials.detail-row', ['label' => 'Inicio', 'value' => \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i A')])
                    @include('partials.detail-row', ['label' => 'Fin', 'value' => \Carbon\Carbon::parse($horario->hora_fin)->format('H:i A')])
                    @include('partials.detail-row', ['label' => 'Duración', 'value' => \Carbon\Carbon::parse($horario->hora_inicio)->diff(\Carbon\Carbon::parse($horario->hora_fin))->format('%h horas y %i minutos')])
                    @include('partials.detail-row', ['label' => 'Modalidad', 'value' => $horario->modalidad ?? 'No definida'])
                    
                    <div class="flex items-start pt-2">
                        <p class="w-1/3 text-sm font-medium text-gray-400">Estado:</p>
                        <p class="w-2/3 text-base font-bold uppercase 
                            @if($horario->estado == 'vigente') text-green-500 
                            @elseif($horario->estado == 'cancelado') text-red-500 
                            @else text-yellow-500 
                            @endif">{{ $horario->estado }}</p>
                    </div>
                </div>

                {{-- Columna 2: Detalles de Asignación --}}
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-gray-300 border-b border-gray-700 pb-2 mb-3">Asignación Académica</h2>
                    
                    @include('partials.detail-row', ['label' => 'Materia', 'value' => $horario->grupoMateria->materia->nombre ?? 'N/A', 'subvalue' => $horario->grupoMateria->materia->sigla ?? ''])
                    @include('partials.detail-row', ['label' => 'Grupo', 'value' => $horario->grupoMateria->grupo->nombre ?? 'N/A'])
                    @include('partials.detail-row', ['label' => 'Gestión', 'value' => ($horario->grupoMateria->gestion->año ?? 'N/A') . ' - ' . ($horario->grupoMateria->gestion->semestre ?? 'N/A')])
                    @include('partials.detail-row', ['label' => 'Aula Asignada', 'value' => $horario->grupoMateria->aula->numero ?? 'Sin Aula', 'subvalue' => $horario->grupoMateria->modulo->codigo ?? 'Sin Módulo'])
                </div>
            </div>

            {{-- Metadatos --}}
            <div class="mt-8 pt-4 border-t border-gray-700 text-xs text-gray-500">
                <p>Registro Creado: {{ $horario->created_at->diffForHumans() }}</p>
                <p>Última Actualización: {{ $horario->updated_at->diffForHumans() }}</p>
            </div>
            
        </div>
    </div>
@endsection