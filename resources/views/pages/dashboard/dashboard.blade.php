@extends('layouts.app')

@section('header', 'Panel de Control Principal')

@section('content')
    <div class="p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-white mb-6">
            Resumen General del Sistema
        </h1>

        {{-- GRID DE TARJETAS DE RESUMEN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            {{-- Tarjeta 1: Docentes --}}
            <div class="bg-gray-800 p-5 rounded-lg shadow-lg border border-indigo-700/50 flex items-center justify-between transition hover:bg-gray-700/50">
                <div>
                    <p class="text-sm font-medium text-indigo-400 uppercase">Docentes</p>
                    <p class="text-3xl font-bold text-white mt-1">
                        {{ $docentes_count }} 
                    </p>
                </div>
                <i class="fa-solid fa-user-tie text-4xl text-indigo-500 opacity-60"></i>
            </div>

            {{-- Tarjeta 2: Usuarios --}}
            <div class="bg-gray-800 p-5 rounded-lg shadow-lg border border-yellow-700/50 flex items-center justify-between transition hover:bg-gray-700/50">
                <div>
                    <p class="text-sm font-medium text-yellow-400 uppercase">Usuarios</p>
                    <p class="text-3xl font-bold text-white mt-1">
                        {{-- Ejemplo de dato dinámico --}}
                        {{ $users_count }} 
                    </p>
                </div>
                <i class="fa-solid fa-user-group text-4xl text-yellow-500 opacity-60"></i>
            </div>

            {{-- Tarjeta 3: Materias --}}
            <div class="bg-gray-800 p-5 rounded-lg shadow-lg border border-green-700/50 flex items-center justify-between transition hover:bg-gray-700/50">
                <div>
                    <p class="text-sm font-medium text-green-400 uppercase">Materias</p>
                    <p class="text-3xl font-bold text-white mt-1">
                        {{-- Ejemplo de dato dinámico --}}
                        {{ $materias_count }}
                    </p>
                </div>
                <i class="fa-solid fa-book-open text-4xl text-green-500 opacity-60"></i>
            </div>

            {{-- Tarjeta 4: Reportes Pendientes --}}
            <div class="bg-gray-800 p-5 rounded-lg shadow-lg border border-red-700/50 flex items-center justify-between transition hover:bg-gray-700/50">
                <div>
                    <p class="text-sm font-medium text-red-400 uppercase">Reportes Pendientes</p>
                    <p class="text-3xl font-bold text-white mt-1">5</p>
                </div>
                <i class="fa-solid fa-triangle-exclamation text-4xl text-red-500 opacity-60"></i>
            </div>
        </div>
        
        {{-- SECCIÓN DE GRÁFICOS Y ACTIVIDAD RECIENTE --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Columna 1 y 2: Gráfico de Ejemplo (Ocupa 2/3 en desktop) --}}
            <div class="lg:col-span-2 bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700">
                <h2 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">Distribución de Docentes por Categoría (Gráfico Placeholder)</h2>
                
                {{-- Placeholder Simple para Simular un Gráfico --}}
                <div class="h-64 bg-gray-700 p-4 rounded flex flex-col justify-end">
                    <div class="flex h-full items-end space-x-4">
                        <div class="w-10 bg-indigo-500 h-2/3 rounded-t" title="Titular: 60%"></div>
                        <div class="w-10 bg-indigo-400 h-1/2 rounded-t" title="Auxiliar: 40%"></div>
                        <div class="w-10 bg-indigo-300 h-1/4 rounded-t" title="Contratado: 25%"></div>
                        <div class="w-10 bg-indigo-200 h-1/6 rounded-t" title="Invitado: 15%"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-gray-400">
                        <span>Titular</span>
                        <span>Auxiliar</span>
                        <span>Contratado</span>
                        <span>Invitado</span>
                    </div>
                </div>
            </div>

            {{-- Columna 3: Actividad Reciente (Ocupa 1/3 en desktop) --}}
            <div class="lg:col-span-1 bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700">
                <h2 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">Últimos Registros</h2>

                <ul class="space-y-4">
                    <li class="p-3 bg-gray-700/50 rounded-md">
                        <p class="text-sm font-semibold text-white">Docente: **Juan Pérez**</p>
                        <p class="text-xs text-gray-400">Registro creado hace 5 minutos.</p>
                    </li>
                    <li class="p-3 bg-gray-700/50 rounded-md">
                        <p class="text-sm font-semibold text-white">Materia: **Cálculo I**</p>
                        <p class="text-xs text-gray-400">Materia actualizada hace 1 hora.</p>
                    </li>
                    <li class="p-3 bg-gray-700/50 rounded-md">
                        <p class="text-sm font-semibold text-white">Usuario: **Admin Test**</p>
                        <p class="text-xs text-gray-400">Inicio de sesión registrado.</p>
                    </li>
                    <li class="p-3 bg-gray-700/50 rounded-md">
                        <p class="text-sm font-semibold text-white">Docente: **María López**</p>
                        <p class="text-xs text-gray-400">Registro editado hace 2 días.</p>
                    </li>
                </ul>
                
                <a href="{{ route('docentes.index') }}" class="mt-4 block text-center text-sm font-medium text-indigo-400 hover:text-indigo-300 transition duration-150">
                    Ver todos los docentes <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

    </div>
@endsection