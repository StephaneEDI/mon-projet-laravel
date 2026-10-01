<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/** Réserve les routes d'administration aux comptes dont le rôle est admin. */
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérification de l'utilisateur connecté
        $user = Auth::user();
        if (!($user instanceof \App\Models\User)) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder au panneau d\'administration.');
        }

        // 2. Vérification du rôle via la méthode définie sur le modèle User
        if (!$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Accès refusé : espace réservé aux administrateurs.');
        }

        return $next($request);
    }
}