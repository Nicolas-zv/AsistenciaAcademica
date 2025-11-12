<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\LogSuccessfulLogin::class,
        ],
        \Illuminate\Auth\Events\Logout::class => [
            \App\Listeners\LogSuccessfulLogout::class,
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. AÑADIR LA LÍNEA CLAVE DENTRO DE boot()
        // Esto fuerza a Laravel a usar la columna 'correo' para la autenticación
        Auth::extend('web', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider'] ?? null);
            return new \Illuminate\Auth\SessionGuard($name, $provider, $app['session.store']);
        });

        // El método simple es este (para fines de depuración/solución directa):
        // $this->app['config']['auth.providers.users.field'] = 'correo';
    }
}
