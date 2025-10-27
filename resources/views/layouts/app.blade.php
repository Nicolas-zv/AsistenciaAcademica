<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gestión Académica FICCT - @yield('header', 'Dashboard')</title>

    {{-- 1. Incluir Tailwind CSS y Alpine.js (Asumiendo que usas Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ87CqjHNK8a2pDk8Xn7FzB6Z5p1uYn7A8Pz6O2J+lM4y8Fp1z4F8O/A4hL0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

{{-- Usamos el fondo y las fuentes del modo oscuro en el body --}}
<body class="font-sans antialiased bg-gray-900 text-gray-100">

    {{-- Contenedor principal de Alpine.js para controlar el sidebar --}}
    <div x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebarExpanded') == 'true' }"
         @keydown.window.escape="sidebarOpen = false"
         class="flex h-screen overflow-hidden">

        {{-- /////////////////////////////////////////////////////////////////////////// --}}
        {{-- //                       COMPONENTES: SIDEBAR                              // --}}
        {{-- /////////////////////////////////////////////////////////////////////////// --}}

        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
             :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

        <div id="sidebar"
            class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 p-4 transition-all duration-200 ease-in-out bg-gray-900 dark:bg-gray-950"
            
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-64': !sidebarOpen }" 
            
            @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false" x-cloak="lg"
            @click="sidebarExpanded = false"
            @resize.window="sidebarExpanded = window.innerWidth > 1024 ? localStorage.getItem('sidebarExpanded') == 'true' : false">

            {{-- Encabezado y Botón de Cerrar (Móvil) --}}
            <div class="flex justify-between mb-3 pr-3 sm:px-2">
                <h1 class="text-xl font-bold text-indigo-400">FICCT</h1>
                <button class="lg:hidden text-slate-400 hover:text-white" @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Cerrar barra lateral</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                    </svg>
                </button>
            </div>

            {{-- Contenido de Navegación --}}
            <div class="space-y-6 flex-grow">
                
                {{-- Función simple para generar enlaces (simulando sidebar-link.blade.php) --}}
                @php
                    function renderSidebarLink($route, $icon, $label) {
                        $active = request()->segment(1) == explode('/', $route)[1];
                        $activeClasses = 'bg-indigo-700/50 ring-2 ring-indigo-500 border-l-4 border-indigo-400';
                        $inactiveClasses = 'hover:bg-gray-700/50';
                        $iconActiveClasses = 'text-indigo-400 font-bold';
                        $iconInactiveClasses = 'text-gray-300';
                        $textInactiveClasses = 'hover:text-indigo-300';

                        echo '<li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 transition duration-150 ease-in-out ' . ($active ? $activeClasses : $inactiveClasses) . '">';
                        echo '<a class="block text-gray-100 truncate transition ' . (!$active ? $textInactiveClasses : '') . '" href="' . $route . '">';
                        echo '<div class="flex items-center">';
                        echo '<span class="text-lg shrink-0 ' . ($active ? $iconActiveClasses : $iconInactiveClasses) . '">' . $icon . '</span>';
                        echo '<span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">' . $label . '</span>';
                        echo '</div></a></li>';
                    }
                @endphp

                {{-- SECCIÓN 1: PANEL --}}
                <div>
                    <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">📊</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Principal</span>
                    </h3>
                    <ul class="mt-3">
                        @php renderSidebarLink(route('dashboard'), '<i class="fa-solid fa-gauge"></i>', 'Dashboard'); @endphp
                    </ul>
                </div>
                
                {{-- SECCIÓN 2: CATÁLOGOS ACADÉMICOS --}}
                <div>
                    <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2 mt-4 border-t border-gray-800 pt-4">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">📚</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Catálogos</span>
                    </h3>
                    <ul class="mt-3">
                        @php renderSidebarLink(route('docentes.index'), '<i class="fa-solid fa-user-tie"></i>', 'Docentes'); @endphp
                        @php renderSidebarLink(route('materias.index'), '<i class="fa-solid fa-book"></i>', 'Materias'); @endphp
                        @php renderSidebarLink(route('grupos.index'), '<i class="fa-solid fa-layer-group"></i>', 'Grupos'); @endphp
                        @php renderSidebarLink(route('modulos.index'), '<i class="fa-solid fa-building"></i>', 'Módulos'); @endphp
                        @php renderSidebarLink(route('aulas.index'), '<i class="fa-solid fa-chalkboard"></i>', 'Aulas'); @endphp
                        @php renderSidebarLink(route('gestion.index'), '<i class="fa-solid fa-calendar-days"></i>', 'Gestiones'); @endphp
                        @php renderSidebarLink(route('grupo_materia.index'), '<i class="fa-solid fa-puzzle-piece"></i>', 'Asignación M-G-G'); @endphp
                        @php renderSidebarLink(route('horarios.index'), '<i class="fa-solid fa-clock"></i>', 'Horarios de Clases'); @endphp
                        {{-- Otros catálogos aquí --}}
                    </ul>
                </div>

                {{-- SECCIÓN 3: ADMINISTRACIÓN DEL SISTEMA --}}
                <div>
                    <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2 mt-4 border-t border-gray-800 pt-4">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">⚙️</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Administración</span>
                    </h3>
                    <ul class="mt-3">
                        
                        @php renderSidebarLink(route('users.index'), '<i class="fa-solid fa-user-group"></i>', 'Usuarios'); @endphp
                        @php renderSidebarLink(route('roles.index'), '<i class="fa-solid fa-shield-halved"></i>', 'Roles'); @endphp
                        @php renderSidebarLink(route('permisos.index'), '<i class="fa-solid fa-key"></i>', 'Permisos'); @endphp
                    </ul>
                </div>

            </div>

            {{-- Bloque de Usuario y Colapsar (Modo Diseño) --}}
            <div class="pt-3 border-t border-gray-700 mt-auto"> 
                <div class="text-xs font-semibold text-gray-400 mb-2 truncate pl-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                    Modo: Diseño
                </div>
                <a href="#" class="w-full text-center px-2 py-2 text-sm font-medium rounded-lg text-white bg-gray-700/50 hover:bg-red-800 transition duration-150">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">🔴</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Autenticación Desactivada</span>
                </a>
            </div>
            
            {{-- Botón Colapsar --}}
            <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end">
                <div class="px-3 py-2">
                    <button @click="sidebarExpanded = !sidebarExpanded; localStorage.setItem('sidebarExpanded', sidebarExpanded)"
                    class="text-slate-400 hover:text-indigo-300 transition duration-150">
                        <span class="sr-only">Expandir / Colapsar barra lateral</span>
                        <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                            <path class="text-gray-500" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                            <path class="text-gray-700" d="M3 23H1V1h2z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- /////////////////////////////////////////////////////////////////////////// --}}
        {{-- //                    CONTENIDO PRINCIPAL (HEADER + MAIN)                // --}}
        {{-- /////////////////////////////////////////////////////////////////////////// --}}

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            {{-- HEADER --}}
            <header class="sticky top-0 bg-gray-900 dark:bg-gray-950 border-b border-gray-800 z-30">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 -mb-px">

                        {{-- Botón de Alternancia Sidebar (Mobile) --}}
                        <div class="flex items-center">
                            <button
                                class="text-gray-500 hover:text-gray-300 lg:hidden"
                                @click.stop="sidebarOpen = !sidebarOpen"
                                aria-controls="sidebar"
                                :aria-expanded="sidebarOpen"
                            >
                                <span class="sr-only">Abrir barra lateral</span>
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm14 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-7 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                </svg>
                            </button>
                        </div>

                        {{-- Título de la Página Actual --}}
                        <div class="flex-grow ml-4">
                            <h1 class="text-xl font-bold text-gray-200">
                                @yield('header', 'Dashboard')
                            </h1>
                        </div>

                        {{-- Área de Usuario (Modo Diseño) --}}
                        <div class="flex items-center space-x-3">
                            
                            {{-- Botón de Notificaciones (Placeholder) --}}
                            <button
                                class="p-2 rounded-full text-gray-400 hover:text-white hover:bg-gray-700 transition duration-150"
                                aria-label="Notificaciones"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.472 6.78 6 9.256 6 12v2.158a2.032 2.032 0 01-.595 1.437L4 17h5m6 0a3 3 0 11-6 0"></path></svg>
                            </button>

                            <div class="hidden sm:flex items-center space-x-2 border-l border-gray-700 pl-4">
                                <span class="text-sm text-gray-400 font-semibold">Modo Diseño</span>
                                {{-- Avatar Básico --}}
                                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-lg ring-2 ring-gray-600">
                                    GS
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main>
                {{-- Aquí se inyectará el contenido de tus vistas CRUD (docentes/index, materias/create, etc.) --}}
                @yield('content')
            </main>
        </div>

    </div>
</body>
</html>