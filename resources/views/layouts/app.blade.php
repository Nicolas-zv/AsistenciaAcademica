{{-- resources/views/layouts/app.blade.php (CÓDIGO COMPLETO Y CORREGIDO) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css', 'resources/js/app.js']) 
    </head>
    <body class="font-sans antialiased">
        
        {{-- 1. CONTENEDOR PRINCIPAL: AQUÍ va el X-DATA global para Alpine.js --}}
        <div x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebarExpanded') == 'true' }"
             @keydown.window.escape="sidebarOpen = false"
             class="min-h-screen bg-gray-100 dark:bg-gray-900">
            
            {{-- Barra de Navegación Superior --}}
            @include('layouts.navigation')

            {{-- CONTENEDOR FLEXIBLE: Sidebar + Contenido Principal --}}
            <div class="flex min-h-screen pt-16"> 

                {{-- 2. SIDEBAR ESTRUCTURA: Contenedor con lógica de colapso --}}
                <div id="sidebar"
                    class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 p-4 transition-all duration-200 ease-in-out bg-gray-800 dark:bg-gray-900 shadow-xl hidden lg:block"
                    
                    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-64': !sidebarOpen }"
                    
                    @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false" x-cloak="lg"
                    @click="sidebarExpanded = false"
                    @resize.window="sidebarExpanded = window.innerWidth > 1024 ? localStorage.getItem('sidebarExpanded') == 'true' : false">

                    {{-- 3. LLAMADA AL CONTENIDO DEL SIDEBAR (Componente de enlaces) --}}
                    <x-app.sidebar /> 
                </div>

                {{-- CONTENIDO PRINCIPAL: Columna Derecha --}}
                <div class="flex-1">

                    {{-- Header (Título de la página, opcional) --}}
                    @isset($header)
                        <header class="bg-white dark:bg-gray-800 shadow">
                            <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <main>
                        {{-- 4. SLOT PRINCIPAL: Recibe el contenido de la vista (ej. docentes/index.blade.php) --}}
                        {{ $slot }}
                    </main>
                    
                </div>
            </div>
        </div>
    </body>
</html>