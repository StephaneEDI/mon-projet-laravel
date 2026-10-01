<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/** Réserve les routes du compte et du panier aux clients authentifiés. */
class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}