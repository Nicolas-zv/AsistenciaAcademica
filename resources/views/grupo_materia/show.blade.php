@extends('layouts.app')

@section('header', 'Detalle de Asignación')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            {{ $grupoMateria->materia->sigla ?? 'N/A' }} - {{ $grupoMateria->grupo->nombre ?? 'N/A' }} ({{ $grupoMateria->gestion->año ?? 'N/A' }})
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-4xl mx-auto">
            
            <div class="flex justify-end space-x-3 mb-6">
                <a href="{{ route('grupo_materia.edit', $grupoMateria) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Editar Asignación
                </a>
                <a href="{{ route('grupo_materia.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver a Asignaciones
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Columna 1: Datos Principales --}}
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-gray-300 border-b border-gray-700 pb-2 mb-3">Datos Académicos</h2>
                    
                    @include('partials.detail-row', ['label' => 'Materia', 'value' => $grupoMateria->materia->nombre ?? 'N/A', 'subvalue' => $grupoMateria->materia->sigla ?? ''])
                    @include('partials.detail-row', ['label' => 'Grupo', 'value' => $grupoMateria->grupo->nombre ?? 'N/A'])
                    @include('partials.detail-row', ['label' => 'Gestión', 'value' => ($grupoMateria->gestion->año ?? 'N/A') . ' - ' . ($grupoMateria->gestion->semestre ?? 'N/A')])
                    @include('partials.detail-row', ['label' => 'Turno', 'value' => $grupoMateria->turno ?? 'No asignado'])
                    @include('partials.detail-row', ['label' => 'Cupo Máximo', 'value' => $grupoMateria->cupo ?? 'N/A'])
                    
                    <div class="flex items-start pt-2">
                        <p class="w-1/3 text-sm font-medium text-gray-400">Estado:</p>
                        <p class="w-2/3 text-base font-bold uppercase {{ $grupoMateria->estado == 'activo' ? 'text-green-500' : 'text-red-500' }}">{{ $grupoMateria->estado }}</p>
                    </div>
                </div>

                {{-- Columna 2: Ubicación --}}
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-gray-300 border-b border-gray-700 pb-2 mb-3">Ubicación Asignada</h2>
                    
                    @include('partials.detail-row', ['label' => 'Módulo', 'value' => $grupoMateria->modulo->nombre ?? 'Sin Módulo', 'subvalue' => $grupoMateria->modulo->codigo ?? ''])
                    @include('partials.detail-row', ['label' => 'Aula', 'value' => $grupoMateria->aula->numero ?? 'Sin Aula', 'subvalue' => $grupoMateria->aula->tipo ?? ''])
                    
                    @if($grupoMateria->aula)
                    <div class="pt-4">
                        <p class="text-sm font-medium text-gray-400 mb-2">Detalles del Aula:</p>
                        <div class="bg-gray-700/50 p-3 rounded-md text-gray-400 text-sm">
                            Capacidad: <span class="font-bold text-indigo-400">{{ $grupoMateria->aula->capacidad ?? 'N/A' }}</span> personas.
                            <span class="block">Ubicación: {{ $grupoMateria->aula->ubicacion ?? 'No especificada.' }}</span>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            {{-- Metadatos --}}
            <div class="mt-8 pt-4 border-t border-gray-700 text-xs text-gray-500">
                <p>Registro Creado: {{ $grupoMateria->created_at->diffForHumans() }}</p>
                <p>Última Actualización: {{ $grupoMateria->updated_at->diffForHumans() }}</p>
            </div>
            
        </div>
    </div>
@endsection

{{-- Nota: Asumiendo que tienes un partials/detail-row.blade.php o lo incluyes aquí para la estética --}}
@php
    // Definiendo la función para simular el partials/detail-row.blade.php
    // Esto es solo para que la vista show funcione sin el partial:
    if (!function_exists('renderDetailRow')) {
        function renderDetailRow($label, $value, $subvalue = null) {
            echo '<div class="flex items-start">
                    <p class="w-1/3 text-sm font-medium text-gray-400">' . $label . ':</p>
                    <p class="w-2/3 text-base text-white font-bold">' . $value . '</p>';
            if ($subvalue) {
                 echo '<span class="text-gray-500 text-sm ml-2">(' . $subvalue . ')</span>';
            }
            echo '</div>';
        }
    }
@endphp
@section('after_content')
    <script>
        // Llamada a la función de simulación
        document.querySelectorAll('[data-include="partials.detail-row"]').forEach(el => {
            const label = el.getAttribute('data-label');
            const value = el.getAttribute('data-value');
            const subvalue = el.getAttribute('data-subvalue');
            el.innerHTML = renderDetailRow(label, value, subvalue);
        });
    </script>
@endsection