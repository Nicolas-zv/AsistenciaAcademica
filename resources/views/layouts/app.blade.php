<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || 
              (localStorage.getItem('theme') === null && window.matchMedia('(prefers-color-scheme: dark)').matches)
}" x-init="
    // Inicializa la clase 'dark' en el <html> al cargar la página
    $watch('darkMode', val => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
        $el.classList.toggle('dark', val);
    });
    $el.classList.toggle('dark', darkMode);
" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sistema de Asistencias FICCT</title>
        <link rel="icon" type="image/png" href="{{ asset('images/Escudo_FICCT.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css', 'resources/js/app.js']) 
    </head>
    <body class="font-sans antialiased">
        
        {{-- 1. CONTENEDOR PRINCIPAL: Alpine Data y Listeners --}}
        <div x-data="{ 
            sidebarOpen: false, 
            sidebarExpanded: localStorage.getItem('sidebarExpanded') == 'true',
            windowWidth: window.innerWidth,
        }"
            @resize.window="windowWidth = window.innerWidth"
            @keydown.window.escape="sidebarOpen = false"
            @toggle-sidebar.window="sidebarOpen = ! sidebarOpen" 
            
            @toggle-sidebar-expanded.window="
                sidebarExpanded = ! sidebarExpanded; 
                $nextTick(() => localStorage.setItem('sidebarExpanded', sidebarExpanded));
            "
            
            {{-- Clases estáticas del contenedor principal (SIN MARGEN DINÁMICO AQUÍ) --}}
            class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-all duration-300 ease-in-out">
            
            {{-- Barra de Navegación Superior (Navbar) --}}
            @include('layouts.navigation')

            {{-- CONTENEDOR FLEXIBLE: Sidebar + Contenido Principal --}}
            <div class="flex min-h-screen pt-16"> 

                {{-- 2. SIDEBAR ESTRUCTURA: Lógica de ancho y visibilidad --}}
                <div id="sidebar"
                    {{-- Visibilidad: Se muestra si 'sidebarOpen' (móvil) o si es desktop (ancho >= 1024) --}}
                    x-show="sidebarOpen || windowWidth >= 1024" 
                    
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="-translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="-translate-x-full opacity-0"
                    
                    class="flex flex-col absolute z-50 left-0 top-0 lg:static lg:left-auto lg:top-0 lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar 
                            w-64 shrink-0 p-4 transition-all duration-300 ease-in-out bg-gray-800 dark:bg-gray-900 shadow-xl"
                    
                    {{-- CLASES DINÁMICAS (ANCHO EN DESKTOP) --}}
                    :class="{ 
                        'lg:w-64 2xl:!w-64': sidebarExpanded && windowWidth >= 1024, 
                        'lg:w-20': !sidebarExpanded && windowWidth >= 1024 
                    }"
                    
                    @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false" 
                    x-cloak> 
                    
                    {{-- LLAMADA AL CONTENIDO DEL SIDEBAR --}}
                    <x-app.sidebar /> 
                </div>

                {{-- CONTENIDO PRINCIPAL: Columna Derecha --}}
                {{-- ⭐ MARGEN DINÁMICO APLICADO AQUÍ (lg:ms-) ⭐ --}}
                <div class="flex-1 min-w-0 transition-all duration-300 ease-in-out" 
                    :class="{ 
                        'lg:ms-64': sidebarExpanded && windowWidth >= 1024, 
                        'lg:ms-20': !sidebarExpanded && windowWidth >= 1024 
                    }"> 

                    {{-- Header --}}
                    @isset($header)
                        <header class="bg-white dark:bg-gray-800 shadow">
                            <div class="sm:max-w-7xl w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <main class="w-full">
                        <div class="sm:max-w-7xl w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $slot }}
                        </div>
                    </main>
                    
                </div>
            </div>
        </div>
    </body>
</html>