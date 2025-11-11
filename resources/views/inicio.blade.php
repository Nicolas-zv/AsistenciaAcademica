{{-- resources/views/welcome.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Sistema de Asistencias FICCT</title>
        <link rel="icon" type="image/png" href="{{ asset('images/Escudo_FICCT.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ESTILO CSS PERSONALIZADO PARA LA MARCA DE AGUA --}}
    <style>
        .watermark-logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Usando el escudo_FICCT que identificaste */
            background-image: url("{{ asset('images/Escudo_FICCT.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 500px; 
            opacity: 0.08;
            pointer-events: none;
            z-index: 1;
        }
    </style>
</head>
<body class="antialiased">
    
    {{-- Contenedor Principal: Pantalla completa, fondo oscuro y centrado --}}
    <div class="relative min-h-screen bg-gray-900 flex items-center justify-center">
        
        {{-- MARCA DE AGUA --}}
        <div class="watermark-logo"></div>
        
        {{-- Contenido Principal (Título y Formulario) --}}
        <div class="max-w-4xl mx-auto p-6 lg:p-8 text-center relative z-20">
            
            {{-- TÍTULO PRINCIPAL --}}
            <div class="flex flex-col items-center mb-8">
                <h1 class="text-6xl font-extrabold text-indigo-400 leading-tight">
                    Sistema de Gestión Académica FICCT
                </h1>
                <p class="mt-4 text-xl text-gray-400 max-w-2xl mx-auto">
                    Optimiza la administración de docentes, materias, horarios y asistencias.
                </p>
            </div>
            
            {{-- CONTENEDOR DEL FORMULARIO DE LOGIN --}}
            @if (Route::has('login') && !Auth::check())
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-800/70 shadow-2xl overflow-hidden sm:rounded-lg mx-auto">
                    
                    <h2 class="text-2xl font-semibold text-white mb-4 border-b border-gray-700 pb-3">Iniciar Sesión</h2>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-input-label for="correo" :value="__('Correo Electrónico')" />
                            
                            {{-- CORRECCIÓN CLAVE: name="correo" --}}
                            <x-text-input 
                                id="correo" 
                                class="block mt-1 w-full" 
                                type="email" 
                                name="correo" 
                                :value="old('correo')" 
                                required autofocus autocomplete="username" 
                            />
                            {{-- CORRECCIÓN CLAVE: errors->get('correo') --}}
                            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Contraseña')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember" class="inline-flex items-center">
                                <input id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                <span class="ms-2 text-sm text-gray-400">{{ __('Recordarme') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-400 hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Iniciar Sesión') }}
                            </x-primary-button>
                        </div>
                        
                        @if (Route::has('register'))
                            <div class="mt-4 border-t border-gray-700 pt-4">
                                <p class="text-sm text-gray-400">¿No tienes cuenta? 
                                    <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 underline">Regístrate aquí</a>
                                </p>
                            </div>
                        @endif
                    </form>

                </div>
            @elseif (Auth::check())
                {{-- Si el usuario ya está logueado, mostrar el botón de Dashboard --}}
                <a href="{{ url('/dashboard') }}" 
                   class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg 
                          transition duration-300 ease-in-out transform hover:scale-105 border border-green-500">
                    Ir al Dashboard
                </a>
            @endif
            
            {{-- Pie de Página Simple --}}
            <div class="text-sm text-gray-500 mt-16">
                Sistema desarrollado para la Facultad de Ingeniería en Ciencias de la Computación y Telecomunicaciones (FICCT).
            </div>

        </div>
    </div>
</body>
</html>