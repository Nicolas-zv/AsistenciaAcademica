@extends('layouts.app')

@section('header', 'Asignación Grupo-Materia-Gestión')

@section('content')
    <div class="p-4 sm:p-8">
        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
            <h1 class="text-3xl font-extrabold text-white">
                Grupos Asignados
            </h1>
            <a href="{{ route('grupo_materia.create') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                <i class="fa-solid fa-plus mr-2"></i> Nueva Asignación
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-600/50 text-white p-4 rounded-lg mb-4 border border-green-500 shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Materia (Grupo)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden sm:table-cell">Gestión</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden md:table-cell">Ubicación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cupo / Turno</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($grupoMaterias as $gm)
                        <tr class="hover:bg-gray-700/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-white">
                                {{ $gm->materia->nombre ?? 'N/A' }} 
                                <span class="text-indigo-400 block font-normal text-xs">({{ $gm->materia->sigla ?? 'N/A' }}) - {{ $gm->grupo->nombre ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 hidden sm:table-cell">
                                {{ $gm->gestion->año ?? 'N/A' }} - {{ $gm->gestion->semestre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 hidden md:table-cell">
                                <span class="text-indigo-500">{{ $gm->aula->numero ?? 'Sin Aula' }}</span> / 
                                <span class="text-gray-500">{{ $gm->modulo->codigo ?? 'Sin Módulo' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span class="text-yellow-500">{{ $gm->cupo ?? 'N/A' }}</span> <span class="text-gray-500 text-xs">cupos</span>
                                <span class="block text-gray-400 text-xs">{{ $gm->turno ?? 'Sin Turno' }}</span>
                                <span class="block text-xs uppercase font-bold {{ $gm->estado == 'activo' ? 'text-green-500' : 'text-red-500' }}">{{ $gm->estado }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center space-x-2">
                                <a href="{{ route('grupo_materia.show', $gm) }}" 
                                    class="text-xs font-semibold text-sky-400 hover:text-sky-300">
                                    <span class="p-2 rounded-full hover:bg-sky-900/50">Ver</span>
                                </a>
                                    <a href="{{ route('grupo_materia.edit', $gm) }}" 
                                        class="text-xs font-semibold text-yellow-400 hover:text-yellow-300">
                                        <span class="p-2 rounded-full hover:bg-yellow-900/50">Editar</span>
                                    </a>
                                    
                                    {{-- Formulario para Eliminar --}}
                                    <form action="{{ route('grupo_materia.destroy', $gm) }}" method="POST" onsubmit="return confirm('¿Está seguro de querer eliminar esta asignación?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-xs font-semibold text-red-500 hover:text-red-400">
                                        <span class="p-2 rounded-full hover:bg-red-900/50">Eliminar</span>
                                    </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                                No hay asignaciones de Grupos-Materia registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection