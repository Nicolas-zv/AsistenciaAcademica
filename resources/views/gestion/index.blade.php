{{-- resources/views/pages/gestion/index.blade.php (CORREGIDO) --}}

{{-- Reemplazamos @extends('layouts.app') con el componente <x-app-layout> --}}
<x-app-layout>
    
    {{-- Reemplazamos @section('header', '...') con <x-slot name="header"> --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestiones Académicas
        </h2>
    </x-slot>

    {{-- Reemplazamos @section('content') con el cuerpo principal (esto llena el $slot) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8">
                
                <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
                    Gestiónes Registradas
                </h1>



                @if (session('success'))
                    <div class="bg-green-600/50 text-white p-4 rounded-lg mb-4 border border-green-500 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="flex justify-end mb-6">
                    <a href="{{ route('gestion.create') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-plus mr-2"></i> Nueva Gestión
                    </a>    
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Gestión</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden md:table-cell">Descripción</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            {{-- Asegúrate de que $gestiones sea pasado por el controlador (GestionController@index) --}}
                            @forelse ($gestiones as $gestion)
                                <tr class="hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-400">
                                        {{ $gestion->año }} 
                                        @if ($gestion->semestre)
                                            <span class="text-gray-400">- {{ $gestion->semestre }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($gestion->estado == 'activa')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                ACTIVA
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                INACTIVA
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 hidden md:table-cell">
                                        {{ Str::limit($gestion->descripcion, 40, '...') ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('gestion.show', $gestion) }}" title="Ver Detalle"
                                               class="text-green-500 hover:text-green-400 p-2 rounded hover:bg-gray-700 transition">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('gestion.edit', $gestion) }}" title="Editar"
                                               class="text-yellow-500 hover:text-yellow-400 p-2 rounded hover:bg-gray-700 transition">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            
                                            {{-- Formulario para Eliminar --}}
                                            <form action="{{ route('gestion.destroy', $gestion) }}" method="POST" onsubmit="return confirm('¿Está seguro de querer eliminar la gestión: {{ $gestion->año }}-{{ $gestion->semestre }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Eliminar"
                                                        class="text-red-500 hover:text-red-400 p-2 rounded hover:bg-gray-700 transition">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                        No hay gestiones académicas registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>