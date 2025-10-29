{{-- resources/views/horarios/index.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Programación de Horarios
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 sm:p-8">
                
                {{-- Encabezado y botón "Nuevo Horario" --}}
                <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white">
                        Horarios de Clases
                    </h1>
                    
                    {{-- El enlace está correcto, usa route() --}}
                    <a href="{{ route('horarios.create') }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-plus mr-2"></i> Registrar Nuevo Horario
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Materia - Grupo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Día / Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden md:table-cell">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Modalidad / Estado</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($horarios as $horario)
                                <tr class="hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-white">
                                        {{ $horario->grupoMateria->materia->sigla ?? 'N/A' }} - {{ $horario->grupoMateria->grupo->nombre ?? 'N/A' }}
                                        <span class="text-gray-500 block text-xs">({{ $horario->grupoMateria->gestion->año ?? 'N/A' }})</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-400">
                                        {{ $horario->dia_nombre }}
                                        <span class="block text-white font-bold">{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 hidden md:table-cell">
                                        Aula N°: <span class="text-green-400">{{ $horario->grupoMateria->aula->numero ?? 'Sin Asignar' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{ $horario->modalidad ?? 'N/A' }}
                                        <span class="block text-xs uppercase font-bold 
                                            @if($horario->estado == 'vigente') text-green-500 
                                            @elseif($horario->estado == 'cancelado') text-red-500 
                                            @else text-yellow-500 
                                            @endif">{{ $horario->estado }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex justify-center space-x-2">
                                            {{-- VER --}}
                                            <a href="{{ route('horarios.show', $horario) }}" 
                                            class="text-xs font-semibold text-sky-400 hover:text-sky-300">
                                            <span class="p-2 rounded-full hover:bg-sky-900/50">Ver</span>
                                            </a>
                                            {{-- EDITAR --}}
                                            <a href="{{ route('horarios.edit', $horario) }}" 
                                                class="text-xs font-semibold text-yellow-400 hover:text-yellow-300">
                                                <span class="p-2 rounded-full hover:bg-yellow-900/50">Editar</span>
                                            </a>

                                            {{-- ELIMINAR --}}
                                            <form action="{{ route('horarios.destroy', $horario) }}" method="POST" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar el registro docente?');">
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
                                        No hay horarios programados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Si usas paginación: --}}
                {{-- <div class="mt-4">
                    {{ $horarios->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>