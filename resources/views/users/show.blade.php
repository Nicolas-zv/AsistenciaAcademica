{{-- resources/views/users/show.blade.php --}}

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle del Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Detalle del Usuario: <span class="text-white dark:text-white">{{ $user->nombre }}</span>
                </h1>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-lg mx-auto">
                    
                    <div class="space-y-4">
                        
                        {{-- ID --}}
                        <div class="pb-2 border-b border-gray-700 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-400">ID del Usuario:</p>
                            <p class="text-lg text-white dark:text-white font-semibold">{{ $user->id }}</p>
                        </div>
                        
                        {{-- Nombre --}}
                        <div>
                            <p class="text-sm font-medium text-gray-400">Nombre Completo:</p>
                            <p class="text-lg text-white dark:text-white">{{ $user->nombre }}</p>
                        </div>

                        {{-- Correo --}}
                        <div>
                            <p class="text-sm font-medium text-gray-400">Correo Electrónico:</p>
                            <p class="text-lg text-white dark:text-white">{{ $user->correo }}</p>
                        </div>
                        
                        {{-- Rol --}}
                        <div>
                            <p class="text-sm font-medium text-gray-400">Rol Asignado:</p>
                            <p class="text-lg text-indigo-300 font-semibold">{{ $user->role->nombre ?? 'Sin Rol Asignado' }}</p>
                        </div>
                        
                        {{-- Estado --}}
                        <div>
                            <p class="text-sm font-medium text-gray-400">Estado:</p>
                            <span class="p-1 rounded-md text-white text-md font-semibold {{ $user->activo ? 'bg-green-600 dark:bg-green-700' : 'bg-red-600 dark:bg-red-700' }}">
                                {{ $user->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>

                    {{-- Metadatos --}}
                    <div class="text-sm text-gray-500 dark:text-gray-400 border-t border-gray-700 dark:border-gray-700 pt-4 mt-6">
                        <p>Creado el: **{{ $user->created_at->format('d/m/Y H:i') }}**</p>
                        <p>Actualizado el: **{{ $user->updated_at->format('d/m/Y H:i') }}**</p>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-start mt-6 space-x-3">
                        <a href="{{ route('users.edit', $user) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 transition duration-150 shadow-md">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> **Editar Usuario**
                        </a>
                        <a href="{{ route('users.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a la Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>