<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    
    {{-- CORRECCIÓN: Usando 'max-w-full' para que la barra de navegación ocupe todo el ancho. --}}
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- 1. LOGO Y TÍTULO DEL SISTEMA (Contiene los botones del Sidebar) --}}
            <div class="flex items-center">
                
                <button 
                    @click="window.innerWidth < 1024 ? $dispatch('toggle-sidebar') : $dispatch('toggle-sidebar-expanded')" 
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out me-2">
                    
                    {{-- Usamos un solo SVG de menú --}}
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <div class="shrink-0 flex items-center">
                    {{-- Logo de FICCT --}}
                    <img 
                        src="{{ asset('images/Escudo_FICCT.png') }}" 
                        alt="Logo del Sistema FICCT"
                        class="block h-9 w-auto" 
                    />
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    {{-- Nombre de la aplicación a la izquierda del menú --}}
                    <span class="inline-flex items-center text-lg font-extrabold text-indigo-500 dark:text-indigo-400">
                        SISTEMA FICCT
                    </span>
                </div>
            </div>

            {{-- 2. AJUSTES Y DROPDOWN DEL USUARIO (HEADER DERECHO) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                {{-- ⭐ INICIO: BOTÓN DE SWITCH MODO OSCURO ⭐ --}}
                <button
                    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
                    @click="
                        darkMode = ! darkMode; 
                        localStorage.setItem('theme', darkMode ? 'dark' : 'light'); 
                        darkMode 
                            ? document.documentElement.classList.add('dark') 
                            : document.documentElement.classList.remove('dark')
                    "
                    x-init="
                        // Aplica el modo al cargar la página si está en localStorage
                        if (localStorage.getItem('theme') === 'dark') {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    "
                    type="button"
                    class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition duration-300 me-4"
                    title="Alternar Modo Oscuro/Claro"
                >
                    {{-- Icono de Sol (Modo Claro) --}}
                    <i x-show="!darkMode" class="fa-solid fa-sun w-5 h-5"></i>
                    {{-- Icono de Luna (Modo Oscuro) --}}
                    <i x-show="darkMode" class="fa-solid fa-moon w-5 h-5"></i>
                </button>
                {{-- ⭐ FIN: BOTÓN DE SWITCH MODO OSCURO ⭐ --}}

                @auth 
                <x-dropdown align="right" width="64">

                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            
                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 text-white font-bold text-lg shadow-md me-2 ring-2 ring-indigo-400">
                                {{ Auth::user()->initials }} 
                            </div>

                            {{-- Nombre del usuario (Visible en pantallas grandes) --}}
                            <div class="hidden lg:inline text-gray-800 dark:text-gray-200 me-1">{{ Auth::user()->nombre }}</div>
                            
                            {{-- Icono de flecha para el Dropdown --}}
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- SECCIÓN SUPERIOR CON NOMBRE Y CORREO --}}
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <p class="font-bold text-base text-gray-900 dark:text-gray-100">{{ Auth::user()->nombre }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ Auth::user()->correo }}</p>
                        </div>

                        {{-- OPCIÓN DE PERFIL --}}
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        
                        {{-- OPCIÓN DE LOGOUT --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth 
            </div>

            {{-- 3. HAMBURGER (MÓVIL) - Este botón controla el menú de usuario de la barra superior, no el sidebar --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú de usuario responsive (despliega las opciones de usuario en móvil) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        
        {{-- ⭐ NOTA: Puedes añadir el switch de modo oscuro aquí también si lo quieres en el menú móvil. ⭐ --}}

        @auth 
        {{-- Enlace del Dashboard (Responsive) --}}
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->nombre }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->correo }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>