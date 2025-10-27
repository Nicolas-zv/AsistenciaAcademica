@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-indigo-400 mb-6">Crear Nuevo Usuario</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 text-sm text-red-200 bg-red-900 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}" class="bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 max-w-lg">
        @csrf

        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-300">Nombre Completo</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="mb-4">
            <label for="correo" class="block text-sm font-medium text-gray-300">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" value="{{ old('correo') }}" required class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div class="mb-4">
            <label for="role_id" class="block text-sm font-medium text-gray-300">Rol</label>
            <select name="role_id" id="role_id" required class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Seleccionar Rol</option>
                @foreach ($roles as $id => $nombre)
                    <option value="{{ $id }}" {{ old('role_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('users.index') }}" class="mr-4 px-4 py-2 text-sm font-medium text-gray-300 hover:text-white rounded-lg">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                Guardar Usuario
            </button>
        </div>
    </form>
@endsection