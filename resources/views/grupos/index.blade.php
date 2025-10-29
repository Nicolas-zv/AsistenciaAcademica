{{-- resources/views/grupos/index.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catálogo de Grupos
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                {{-- Encabezado y Botón de Creación --}}

                    <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
                        Grupos Registrados
                    </h1>


                {{-- Mensajes de Sesión (Success/Éxito) --}}
                @if (session('success'))
                    <div class="bg-green-600/50 text-white p-4 rounded-lg mb-4 border border-green-500 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-end mb-6">
                    <a href="{{ route('grupos.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150">
                        <i class="fa-solid fa-plus mr-2"></i>Nuevo Grupo
                    </a>
                </div>
                {{-- Tabla de Grupos --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden sm:table-cell">Descripción</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 dark:divide-gray-800">
                            @forelse ($grupos as $grupo)
                                <tr class="hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-400 dark:text-indigo-400">{{ $grupo->nombre }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 hidden sm:table-cell">
                                        {{ Str::limit($grupo->descripcion, 50, '...') ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex justify-center space-x-2">
                                            {{-- Ver --}}
                                            <a href="{{ route('grupos.show', $grupo) }}" 
                                               class="text-xs font-semibold text-sky-400 hover:text-sky-300">
                                                <span class="p-2 rounded-full hover:bg-sky-900/50">Ver</span>
                                            </a>
                                            {{-- Editar --}}
                                            <a href="{{ route('grupos.edit', $grupo) }}" 
                                               class="text-xs font-semibold text-yellow-400 hover:text-yellow-300">
                                                <span class="p-2 rounded-full hover:bg-yellow-900/50">Editar</span>
                                            </a>

                                            {{-- Eliminar --}}
                                            <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" 
                                                  onsubmit="return confirm('¿Está seguro de eliminar el registro del grupo: {{ $grupo->nombre }}?');"
                                                  class="inline">
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
                                        No hay grupos registrados en el sistema.
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