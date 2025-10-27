@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-indigo-400 mb-6">Gestión de Usuarios</h1>
    
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-200 bg-green-900 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
            Crear Nuevo Usuario
        </a>
    </div>

    <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="text-left text-gray-400 border-b border-gray-700">
                    <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Nombre</th>
                    <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Correo</th>
                    <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Rol</th>
                    <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Estado</th>
                    <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                        <td class="px-5 py-5 text-sm">{{ $user->nombre }}</td>
                        <td class="px-5 py-5 text-sm">{{ $user->correo }}</td>
                        <td class="px-5 py-5 text-sm">
                            <span class="p-1 rounded-md bg-indigo-900 text-indigo-200">
                                {{ $user->role->nombre ?? 'Sin Rol' }}
                            </span>
                        </td>
                        <td class="px-5 py-5 text-sm">
                            <span class="p-1 rounded-md {{ $user->activo ? 'bg-green-700' : 'bg-red-700' }} text-white text-xs">
                                {{ $user->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-5 py-5 text-sm flex space-x-2">
                            <a href="{{ route('users.edit', $user) }}" class="text-yellow-400 hover:text-yellow-300">Editar</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar a {{ $user->nombre }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">
            {{ $users->links() }}
        </div>
    </div>
@endsection