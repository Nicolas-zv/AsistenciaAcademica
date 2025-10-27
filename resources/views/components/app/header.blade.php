<header class="sticky top-0 bg-gray-900 dark:bg-gray-950 border-b border-gray-800 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">

            {{-- 1. Barra Lateral: Botón de Alternancia (Necesita acceso a sidebarOpen) --}}
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

            {{-- 2. Título de la Página Actual --}}
            <div class="flex-grow ml-4">
                 <h1 class="text-xl font-bold text-gray-200">
                    @yield('header', 'Dashboard')
                </h1>
            </div>

            {{-- 3. Área de Usuario (Modo Diseño) --}}
            <div class="flex items-center space-x-3">
                <button
                    class="p-2 rounded-full text-gray-400 hover:text-white hover:bg-gray-700 transition duration-150"
                    aria-label="Notificaciones"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.472 6.78 6 9.256 6 12v2.158a2.032 2.032 0 01-.595 1.437L4 17h5m6 0a3 3 0 11-6 0"></path></svg>
                </button>

                <div class="hidden sm:flex items-center space-x-2 border-l border-gray-700 pl-4">
                    <span class="text-sm text-gray-400 font-semibold">Modo Diseño</span>
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-lg ring-2 ring-gray-600">
                        GS
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>