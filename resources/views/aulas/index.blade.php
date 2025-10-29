{{-- resources/views/aulas/index.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catálogo de Aulas
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">
                
               <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
                    Aulas Registradas
                </h1>

                @if (session('success'))
                    <div class="bg-green-600/50 text-white p-4 rounded-lg mb-4 border border-green-500 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="flex justify-end mb-6">
                    <a href="{{ route('aulas.create') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-plus mr-2"></i> Nueva Aula
                    </a>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Número</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Módulo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden md:table-cell">Capacidad / Tipo</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($aulas as $aula)
                                <tr class="hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-400">{{ $aula->numero }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $aula->modulo->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 hidden md:table-cell">
                                        {{ $aula->capacidad ? $aula->capacidad . ' personas' : 'Capacidad N/A' }} 
                                        <span class="text-xs text-gray-500 block">{{ $aula->tipo ?? 'Tipo N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('aulas.show', $aula) }}" title="Ver Detalle"
                                               class="text-green-500 hover:text-green-400 p-2 rounded hover:bg-gray-700 transition">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('aulas.edit', $aula) }}" title="Editar"
                                               class="text-yellow-500 hover:text-yellow-400 p-2 rounded hover:bg-gray-700 transition">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            
                                            {{-- Formulario para Eliminar --}}
                                            <form action="{{ route('aulas.destroy', $aula) }}" method="POST" onsubmit="return confirm('¿Está seguro de querer eliminar el aula N° {{ $aula->numero }}?');" class="inline">
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
                                        No hay aulas registradas.
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