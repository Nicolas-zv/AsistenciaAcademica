{{-- resources/views/grupo_materia/index.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Asignación Grupo-Materia-Gestión
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                {{-- Encabezado y Botón de Creación --}}
                {{-- <div class="flex justify-between items-center mb-6 border-b border-gray-700 dark:border-gray-700 pb-3"> --}}
                    <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
                        Grupos Asignados
                    </h1>

                {{-- </div> --}}

                {{-- Mensajes de Sesión (Success/Éxito) --}}
                @if (session('success'))
                    <div class="bg-green-600/50 text-white p-4 rounded-lg mb-4 border border-green-500 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="flex justify-end mb-6">
                    <a href="{{ route('grupo_materia.create') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                        <i class="fa-solid fa-plus mr-2"></i> Nueva Asignación
                    </a>
                </div>
                {{-- Tabla de Asignaciones --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Materia (Grupo)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden sm:table-cell">Gestión</th>
                                
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden md:table-cell">Docente</th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden md:table-cell">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cupo / Turno</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 dark:divide-gray-800">
                            @forelse ($grupoMaterias as $gm)
                                <tr class="hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $gm->materia->nombre ?? 'N/A' }} 
                                        <span class="text-indigo-400 block font-normal text-xs">({{ $gm->materia->sigla ?? 'N/A' }}) - {{ $gm->grupo->nombre ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 hidden sm:table-cell">
                                        {{ $gm->gestion->año ?? 'N/A' }} - {{ $gm->gestion->semestre ?? 'N/A' }}
                                    </td>
                                    
                                    {{-- Celda de Docente --}}
                                    <td class="px-6 py-4 text-sm text-yellow-500 dark:text-yellow-300 hidden md:table-cell">
                                        {{ $gm->docente->nombre_completo ?? 'PENDIENTE' }} 
                                    </td>
                                    
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 hidden md:table-cell">
                                        <span class="text-indigo-500">{{ $gm->aula->numero ?? 'Sin Aula' }}</span> / 
                                        <span class="text-gray-500">{{ $gm->modulo->codigo ?? 'Sin Módulo' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="text-yellow-500">{{ $gm->cupo ?? 'N/A' }}</span> <span class="text-gray-500 text-xs">cupos</span>
                                        <span class="block text-gray-400 text-xs">{{ $gm->turno ?? 'Sin Turno' }}</span>
                                        {{-- Indicador de estado --}}
                                        <span class="block text-xs uppercase font-bold 
                                            @if ($gm->estado == 'activo') 
                                                text-green-500 
                                            @elseif ($gm->estado == 'cerrado')
                                                text-red-500
                                            @else
                                                text-sky-500
                                            @endif
                                        ">{{ $gm->estado }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex justify-center space-x-2">
                                            {{-- Ver --}}
                                            <a href="{{ route('grupo_materia.show', $gm) }}" 
                                                    class="text-xs font-semibold text-sky-400 hover:text-sky-300">
                                                    <span class="p-2 rounded-full hover:bg-sky-900/50">Ver</span>
                                            </a>
                                            {{-- Editar --}}
                                            <a href="{{ route('grupo_materia.edit', $gm) }}" 
                                                    class="text-xs font-semibold text-yellow-400 hover:text-yellow-300">
                                                    <span class="p-2 rounded-full hover:bg-yellow-900/50">Editar</span>
                                            </a>
                                            
                                            {{-- Eliminar --}}
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
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                        No hay asignaciones de Grupos-Materia registradas.
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