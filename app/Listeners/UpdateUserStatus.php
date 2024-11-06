<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;

class UpdateUserStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = Auth::user(); // Utilisateur actuellement connecté ou déconnecté

        if ($event instanceof Login) {
            // Lors de la connexion, définir is_connected à true
            $user->is_connected = true;
            $user->save();
        }

        if ($event instanceof Logout) {
            // Lors de la déconnexion, définir is_connected à false
            $user->is_connected = false;
            $user->save();
        }
    }
}
