{{-- resources/views/pages/dashboard/dashboard.blade.php --}}

<x-app-layout>
    {{-- 1. HEADER: Pasa el título al slot $header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Panel de Control Principal
        </h2>
    </x-slot>

    {{-- 2. CONTENT: El resto del contenido pasa al slot $slot (dentro del <main>) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Inicio del contenido que antes estaba en @section('content') --}}
            <div class="p-4 sm:p-8">
                <h1 class="text-3xl font-extrabold text-white mb-6">
                    Resumen General del Sistema
                </h1>

                {{-- GRID DE TARJETAS DE RESUMEN (4 Columnas) --}}
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


                {{-- SECCIÓN INFERIOR: GRUPO DE 3 COLUMNAS --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- COLUMNA 1 y 2: LOGO INSTITUCIONAL (OCUPA 2/3) --}}
                    {{-- <div class="lg:col-span-2 bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700"> --}}

                        {{-- Bloque de Título Centrado y Separado --}}
                        {{-- <div class="text-center border-b border-gray-700 pb-3 mb-4">
                            <h2 class="text-2xl font-extrabold text-indigo-400">
                                Logo Institucional
                            </h2>
                            <p class="text-sm text-gray-400 mt-1">Facultad de Ingeniería en Ciencias de la Computación y Telecomunicaciones</p>
                        </div> --}}

                        {{-- Bloque de la Imagen del Logo --}}
                        {{-- <div class="flex justify-center items-center h-15"> 
                            <img src="{{ asset('images/Escudo_FICCT.png') }}" 
                                alt="Escudo FICCT" 
                                class="w-15 h-15 object-contain"
                            >
                        </div>

                    </div> --}}
                    {{-- FIN COLUMNA 1 y 2 --}}


                    {{-- COLUMNA 3: DESARROLLADORES DEL SISTEMA (OCUPA 1/3) --}}
                    <div class="lg:col-span-1 bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700">
                        <h2 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">
                            <i class="fa-solid fa-code me-3 text-emerald-500"></i> Desarrolladores del Sistema
                        </h2>

                        <div class="space-y-6">
                            
                            {{-- Bloque para Programador 1 --}}
                            <div class="flex items-center space-x-4 p-3 bg-gray-700/50 rounded-lg">
                                <img src="{{ asset('images/Nico.png') }}" 
                                    alt="Foto Programador 1" 
                                    class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500"
                                >
                                <div>
                                    <p class="text-lg font-semibold text-white">Nicolas Zalazar</p>
                                    <p class="text-sm text-gray-400">Ingenieria Informatica</p>
                                </div>
                            </div>

                            {{-- Bloque para Programador 2 --}}
                            <div class="flex items-center space-x-4 p-3 bg-gray-700/50 rounded-lg">
                                <img src="{{ asset('images/yary.jpg') }}" 
                                    alt="Foto Programador 2" 
                                    class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500"
                                >
                                <div>
                                    <p class="text-lg font-semibold text-white">Yaryta Montaño</p>
                                    <p class="text-sm text-gray-400">Ingenieria Informatica</p>
                                </div>
                            </div>
                            
                        </div>
                        
                        <p class="text-xs text-center text-gray-500 mt-6">
                            Sistema creado para la FICCT.
                        </p>
                    </div>
                    {{-- FIN COLUMNA 3 --}}

                </div>
                {{-- FIN SECCIÓN INFERIOR --}}

            </div>
            {{-- Fin del contenido --}}
            
        </div>
    </div>
</x-app-layout>