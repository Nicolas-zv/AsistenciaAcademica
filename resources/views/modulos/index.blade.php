@extends('layouts.app')

@section('header', 'Catálogo de Módulos')

@section('content')
    <div class="p-4 sm:p-8">
        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
            <h1 class="text-3xl font-extrabold text-white">
                Módulos Registrados
            </h1>
            <a href="{{ route('modulos.create') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                <i class="fa-solid fa-plus mr-2"></i> Nuevo Módulo
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($modulos as $modulo)
                        <tr class="hover:bg-gray-700/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-white">{{ $modulo->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-400">{{ $modulo->codigo ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center space-x-2">
                                <a href="{{ route('modulos.show', $modulo) }}" 
                                   class="text-xs font-semibold text-sky-400 hover:text-sky-300">
                                    <span class="p-2 rounded-full hover:bg-sky-900/50">Ver</span>
                                </a>
                                <a href="{{ route('modulos.edit', $modulo) }}" 
                                   class="text-xs font-semibold text-yellow-400 hover:text-yellow-300">
                                    <span class="p-2 rounded-full hover:bg-yellow-900/50">Editar</span>
                                </a>

                                <form action="{{ route('modulos.destroy', $modulo) }}" method="POST" 
                                      onsubmit="return confirm('¿Está seguro de eliminar el registro del módulo: {{ $modulo->nombre }}?');">
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
                            <td colspan="3" class="px-6 py-4 text-center text-gray-400">
                                No hay módulos registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection