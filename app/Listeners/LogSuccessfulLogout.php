<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogout
{
    public function handle(Logout $event)
    {
        $user = $event->user;

        if ($user) {
            activity()
                ->causedBy($user)
                ->withProperties(['usuario' => $user->nombre ?? $user->email])
                ->log('Cierre de sesión en el sistema.');
        }
    }
}
