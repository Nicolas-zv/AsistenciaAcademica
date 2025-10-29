{{-- resources/views/roles/show.blade.php --}}

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle del Rol
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Detalle del Rol: <span class="text-white dark:text-white">{{ $role->nombre }}</span>
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-2xl mx-auto">
                    
                    {{-- Información Básica --}}
                    <div class="pb-4 mb-4 border-b border-gray-700 dark:border-gray-700 space-y-3">
                        
                        <div>
                            <p class="text-sm font-medium text-gray-400">ID del Rol:</p>
                            <p class="text-lg text-white dark:text-white font-semibold">{{ $role->id }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-400">Nombre:</p>
                            <p class="text-xl text-white dark:text-white">{{ $role->nombre }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-400">Descripción:</p>
                            <div class="bg-gray-700/50 p-3 rounded-md text-gray-300 whitespace-pre-wrap text-lg">
                                {{ $role->descripcion ?? 'Sin descripción.' }}
                            </div>
                        </div>
                    </div>

                    {{-- Permisos Asignados --}}
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-200 mb-3 border-b border-gray-700 pb-2">Permisos Asignados</h2>
                        
                        @if ($role->permissions->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 bg-gray-700/30 rounded-lg">
                                @foreach ($role->permissions as $permiso)
                                    <div class="flex items-center text-sm text-green-300">
                                        <i class="fa-solid fa-check-circle mr-2 text-green-500"></i> {{ $permiso->nombre }}
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-yellow-400 p-3 bg-yellow-900/30 rounded-lg">Este rol no tiene permisos asignados.</p>
                        @endif
                    </div>

                    {{-- Metadatos --}}
                    <div class="text-sm text-gray-500 dark:text-gray-400 border-t border-gray-700 dark:border-gray-700 pt-4 mt-6">
                        <p>Creado el: **{{ $role->created_at->format('d/m/Y H:i') }}**</p>
                        <p>Actualizado el: **{{ $role->updated_at->format('d/m/Y H:i') }}**</p>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-start mt-6 space-x-3">
                        <a href="{{ route('roles.edit', $role) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> **Editar Rol**
                        </a>
                        <a href="{{ route('roles.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>