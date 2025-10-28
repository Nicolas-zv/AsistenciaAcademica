{{-- resources/views/asistencias/index.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista de Asistencias Registradas
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 sm:p-8">
                
                {{-- Encabezado y botón --}}
                <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-3">
                    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white">
                        Registro Histórico de Asistencias
                    </h1>
                    
                    <a href="{{ route('asistencias.create') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 shadow-md">
                       <i class="fa-solid fa-plus mr-2"></i> Registrar Asistencia
                    </a>
                </div>

                {{-- Mensajes de Sesión --}}
                @if (session('success'))
                    <div class="bg-green-600/50 text-white p-4 rounded-lg mb-4 border border-green-500 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tabla de Asistencias --}}
                <div class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Fecha / Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Materia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Horario</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($asistencias as $asistencia)
                                <tr class="hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                        {{ optional(optional($asistencia->docente)->user)->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/M/Y') }}
                                        @if($asistencia->hora)
                                            <span class="text-xs text-gray-500 block">{{ \Carbon\Carbon::parse($asistencia->hora)->format('H:i') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ optional(optional($asistencia->grupoMateria)->materia)->sigla ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ optional($asistencia->horario)->dia_nombre ?? 'N/A' }} 
                                        <span class="text-xs text-gray-500 block">
                                            {{ optional($asistencia->horario)->hora_inicio ?? '' }} - {{ optional($asistencia->horario)->hora_fin ?? '' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold">
                                        @php
                                            $statusClass = [
                                                'presente' => 'bg-green-600',
                                                'ausente' => 'bg-red-600',
                                                'tarde' => 'bg-yellow-600',
                                            ][$asistencia->estado] ?? 'bg-gray-500';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white {{ $statusClass }}">
                                            {{ ucfirst($asistencia->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs text-gray-400">
                                        {{ ucfirst($asistencia->tipo_registro ?? 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            {{-- Ver --}}
                                            <a href="{{ route('asistencias.show', $asistencia->id) }}" 
                                               class="text-indigo-400 hover:text-indigo-300 transition" title="Ver">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            {{-- Editar --}}
                                            <a href="{{ route('asistencias.edit', $asistencia->id) }}" 
                                               class="text-yellow-400 hover:text-yellow-300 transition" title="Editar">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            {{-- Eliminar --}}
                                            <form action="{{ route('asistencias.destroy', $asistencia->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro de asistencia?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Eliminar">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{-- Paginación --}}
                    <div class="mt-4">
                        {{ $asistencias->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>