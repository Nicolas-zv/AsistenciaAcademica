{{-- resources/views/materias/index.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>

    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catálogo de Materias
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">


                <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
                    Materias Registradas
                </h1>



                {{-- Mensaje de Éxito --}}
                @if (session('success'))
                <div class="bg-green-600/50 text-white p-4 rounded-lg mb-4 border border-green-500 shadow-md">
                    {{ session('success') }}
                </div>
                @endif
                <div class="flex justify-end mb-6">
                    <a href="{{ route('materias.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150">
                       <i class="fa-solid fa-plus mr-2"></i> Nueva Materia
                    </a>
                </div>

                {{-- Tabla de Materias --}}
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                                    Sigla</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                                    Nombre</th>
                                {{-- Columnas opcionales: Créditos y Carga Horaria --}}
                                {{-- <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Créditos</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Carga Horaria</th> --}}
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-400 dark:text-gray-400 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700 dark:divide-gray-800">
                            @forelse ($materias as $materia)
                            <tr class="hover:bg-gray-700/50 transition duration-150">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-400 dark:text-indigo-400">
                                    {{ $materia->sigla }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{
                                    $materia->nombre }}</td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-400">{{
                                    $materia->creditos }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $materia->carga_horaria
                                    }} Hrs/Sem</td> --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <div class="flex justify-center space-x-2">

                                        {{-- Ver --}}
                                        <a href="{{ route('materias.show', $materia) }}"
                                            class="text-xs font-semibold text-sky-500 hover:text-sky-400 dark:text-sky-400 dark:hover:text-sky-300">
                                            <span class="p-2 rounded-full hover:bg-sky-900/50">Ver</span>
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('materias.edit', $materia) }}"
                                            class="text-xs font-semibold text-yellow-500 hover:text-yellow-400 dark:text-yellow-400 dark:hover:text-yellow-300">
                                            <span class="p-2 rounded-full hover:bg-yellow-900/50">Editar</span>
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('materias.destroy', $materia) }}" method="POST"
                                            onsubmit="return confirm('¿Está seguro de querer eliminar la materia: {{ $materia->nombre }}?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-xs font-semibold text-red-500 hover:text-red-400 dark:text-red-500 dark:hover:text-red-400">
                                                <span class="p-2 rounded-full hover:bg-red-900/50">Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No hay materias registradas en el sistema.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Enlaces de paginación --}}
                {{-- Si el controlador devuelve $materias con paginate(), descomenta el siguiente div: --}}
                @if (method_exists($materias, 'links'))
                <div class="mt-4">
                    {{ $materias->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>