@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-indigo-400 mb-6 border-b border-gray-700 pb-3">
            Gestión de Roles (Usuarios)
        </h1>
        
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-200 bg-green-800/70 rounded-lg border border-green-700" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-6">
            <a href="{{ route('roles.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                ➕ Crear Nuevo Rol
            </a>
        </div>

        <div class="bg-gray-800 shadow-xl rounded-lg overflow-hidden border border-gray-700">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-700 bg-gray-700/50">
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider w-1/12">ID</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider w-2/12">Nombre del Rol</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider w-6/12">Descripción</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider w-3/12 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition duration-100">
                            <td class="px-5 py-3 text-sm text-gray-300">
                                {{ $role->id }}
                            </td>
                            <td class="px-5 py-3 text-sm font-medium text-white">
                                {{ $role->nombre }}
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-400">
                                {{ $role->descripcion ?? 'N/A' }}
                            </td>
                            <td class="px-5 py-3 text-sm flex space-x-3 justify-center items-center">
                                
                                <a href="{{ route('roles.edit', $role) }}" 
                                   class="text-xs font-semibold text-yellow-400 hover:text-yellow-300 transition duration-150">
                                    <span class="p-2 rounded-full hover:bg-yellow-900/50">Editar</span>
                                </a>

                                <form action="{{ route('roles.destroy', $role) }}" method="POST" 
                                      onsubmit="return confirm('¿Está seguro de eliminar el rol: {{ $role->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-xs font-semibold text-red-500 hover:text-red-400 transition duration-150">
                                        <span class="p-2 rounded-full hover:bg-red-900/50">Eliminar</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b border-gray-700">
                            <td colspan="4" class="px-5 py-5 text-sm text-gray-400 text-center">
                                No se encontraron roles.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="p-5 border-t border-gray-700 bg-gray-700/30">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection