<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class UpdateLastActivity
{
   
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Récupérez l'utilisateur authentifié
            $user = Auth::user();
            
            // Mettez à jour le champ last_activity avec le timestamp actuel
            $user->last_activity = Carbon::now();
            
            // Enregistrez les modifications apportées au modèle de l'utilisateur
            // C'est cette ligne qui effectue la mise à jour dans la base de données
            $user->save();
        }

        // Continuez le traitement de la requête
        return $next($request);
    }
}
