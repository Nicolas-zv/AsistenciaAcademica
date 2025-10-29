{{-- resources/views/users/index.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestión de Usuarios
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Gestión de Usuarios
                </h1>
                
                {{-- Mensaje de Éxito --}}
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-200 bg-green-800/70 rounded-lg border border-green-700 dark:bg-green-900/70 dark:border-green-700" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Botón de Creación --}}
                <div class="flex justify-end mb-6">
                    <a href="{{ route('users.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150 shadow-md">
                        <i class="fa-solid fa-user-plus mr-2"></i> Crear Nuevo Usuario
                    </a>
                </div>

                {{-- Tabla de Usuarios --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden border border-gray-700 dark:border-gray-700">
                    <table class="min-w-full leading-normal text-gray-900 dark:text-white">
                        <thead>
                            <tr class="text-left text-gray-600 dark:text-gray-400 border-b border-gray-700 dark:border-gray-700 bg-gray-100 dark:bg-gray-700/50">
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Nombre</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Correo</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Rol</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Estado</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-100">
                                    <td class="px-5 py-4 text-sm">{{ $user->nombre }}</td>
                                    <td class="px-5 py-4 text-sm">{{ $user->correo }}</td>
                                    <td class="px-5 py-4 text-sm">
                                        <span class="p-1 rounded-md bg-indigo-900 dark:bg-indigo-900 text-indigo-200 text-xs font-medium">
                                            {{ $user->role->nombre ?? 'Sin Rol' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-sm">
                                        <span class="p-1 rounded-md text-white text-xs font-semibold {{ $user->activo ? 'bg-green-600 dark:bg-green-700' : 'bg-red-600 dark:bg-red-700' }}">
                                            {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-sm flex space-x-3 justify-center items-center">
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('users.edit', $user) }}" 
                                           class="text-sm font-medium text-yellow-600 hover:text-yellow-500 dark:text-yellow-400 dark:hover:text-yellow-300">
                                            Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                              onsubmit="return confirm('¿Seguro que deseas eliminar a {{ $user->nombre }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-sm font-medium text-red-600 hover:text-red-500 dark:text-red-500 dark:hover:text-red-400">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b border-gray-700 dark:border-gray-700">
                                    <td colspan="5" class="px-5 py-5 text-sm text-gray-500 dark:text-gray-400 text-center">
                                        No se encontraron usuarios.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    {{-- Paginación --}}
                    @if (method_exists($users, 'links'))
                        <div class="p-5 border-t border-gray-700 dark:border-gray-700 bg-gray-100 dark:bg-gray-700/30">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>