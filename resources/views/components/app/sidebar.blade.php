<div x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebarExpanded') == 'true' }"
     @keydown.window.escape="sidebarOpen = false">

    {{-- Overlay oscuro para móvil --}}
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
            
            {{-- Función para simular el componente sidebar-link.blade.php --}}
            @php
                function renderSidebarLink($route, $icon, $label) {
                    // Usamos request()->segment(1) para verificar la ruta activa
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
            
            {{-- SECCIÓN: Catálogos --}}
            <div>
                <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2 mt-4 border-t border-gray-800 pt-4">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">📚</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Catálogos</span>
                </h3>
                <ul class="mt-3">

                    @php renderSidebarLink(route('docentes.index'), '<i class="fa-solid fa-user-tie"></i>', 'Docentes'); @endphp
                    @php renderSidebarLink(route('materias.index'), '<i class="fa-solid fa-book"></i>', 'Materias'); @endphp
                    @php renderSidebarLink(route('grupos.index'), '<i class="fa-solid fa-layer-group"></i>', 'Grupos'); @endphp
                    @php renderSidebarLink(route('modulos.index'), '<i class="fa-solid fa-th-large"></i>', 'Módulos'); @endphp
                    @php renderSidebarLink(route('aulas.index'), '<i class="fa-solid fa-chalkboard"></i>', 'Aulas'); @endphp  
                    @php renderSidebarLink(route('gestion.index'), '<i class="fa-solid fa-calendar-days"></i>', 'Gestiones'); @endphp
                    @php renderSidebarLink(route('grupo_materia.index'), '<i class="fa-solid fa-layer-group"></i>', 'Grupos-Materia'); @endphp
                    
                </ul>
            </div>

            {{-- SECCIÓN: Administración --}}
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

        {{-- Bloque de Colapsar (Solo desktop) --}}
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
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
</div>