<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;

        activity()
            ->causedBy($user)
            ->withProperties(['usuario' => $user->nombre ?? $user->email])
            ->log('Inicio de sesión en el sistema.');
    }
}
