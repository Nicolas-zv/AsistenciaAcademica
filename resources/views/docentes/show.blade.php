@extends('layouts.app')

@section('header', 'Detalle de Docente')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Detalle del Docente
        </h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-4xl mx-auto">
            
            <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-6">
                <h2 class="text-2xl font-bold text-white">
                    {{ $docente->user->nombre ?? 'Usuario Desvinculado' }}
                </h2>
                <div class="flex space-x-3">
                    <a href="{{ route('docentes.edit', $docente) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150">
                        <i class="fa-solid fa-pen-to-square mr-2"></i> Editar
                    </a>
                    <a href="{{ route('docentes.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-md hover:bg-gray-600 transition duration-150">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">

                {{-- Columna de Datos de Usuario --}}
                <div class="space-y-4 border-r border-gray-700 md:pr-6">
                    <h3 class="text-lg font-semibold text-indigo-400 border-b border-gray-600 pb-2 mb-3">Datos de Usuario Asociado</h3>
                    
                    @if ($docente->user)
                        <div class="detail-item">
                            <p class="text-sm font-medium text-gray-400">ID de Usuario:</p>
                            <p class="text-base text-white font-bold">{{ $docente->user_id }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="text-sm font-medium text-gray-400">Correo Electrónico:</p>
                            <p class="text-base text-white">{{ $docente->user->correo }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="text-sm font-medium text-gray-400">Teléfono:</p>
                            <p class="text-base text-white">{{ $docente->user->telefono ?? 'N/A' }}</p>
                        </div>
                        <div class="detail-item">
                            <p class="text-sm font-medium text-gray-400">Rol:</p>
                            <p class="text-base text-white">{{ $docente->user->role->nombre ?? 'Sin Rol' }}</p>
                        </div>
                    @else
                        <p class="text-red-400 bg-red-900/30 p-3 rounded-md">El usuario vinculado ha sido eliminado o desvinculado.</p>
                    @endif
                </div>

                {{-- Columna de Datos de Docente --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-indigo-400 border-b border-gray-600 pb-2 mb-3">Información Docente</h3>

                    <div class="detail-item">
                        <p class="text-sm font-medium text-gray-400">Código Docente:</p>
                        <p class="text-base text-white">{{ $docente->codigo ?? 'N/A' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="text-sm font-medium text-gray-400">Especialidad:</p>
                        <p class="text-base text-white">{{ $docente->especialidad ?? 'N/A' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="text-sm font-medium text-gray-400">Categoría:</p>
                        <p class="text-base text-white">{{ $docente->categoria ?? 'N/A' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="text-sm font-medium text-gray-400">Carga Horaria:</p>
                        <p class="text-base text-yellow-400 font-bold">{{ $docente->carga_horaria }} Hrs/Sem</p>
                    </div>
                    <div class="detail-item">
                        <p class="text-sm font-medium text-gray-400">Fecha de Contrato:</p>
                        <p class="text-base text-white">{{ $docente->fecha_contrato ? $docente->fecha_contrato->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                </div>

            </div>

            {{-- Pie de Página / Metadatos --}}
            <div class="mt-8 pt-4 border-t border-gray-700 text-xs text-gray-500">
                <p>Registro Creado: {{ $docente->created_at->diffForHumans() }} ({{ $docente->created_at->format('d/m/Y H:i') }})</p>
                <p>Última Actualización: {{ $docente->updated_at->diffForHumans() }} ({{ $docente->updated_at->format('d/m/Y H:i') }})</p>
            </div>
            
        </div>
    </div>
@endsection