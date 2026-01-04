<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Vous devez être connecté pour accéder à cette page.']);
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur a l'un des rôles autorisés
        if (!in_array($user->role, $roles)) {
            // Message d'erreur plus détaillé pour le débogage
            $allowedRoles = implode(', ', $roles);
            $errorMessage = "Accès non autorisé. Votre rôle ({$user->role}) n'est pas autorisé. Rôles autorisés: {$allowedRoles}";

            // Rediriger vers la page d'accueil au lieu d'abort
            return redirect()->route('home')->withErrors(['error' => $errorMessage]);
        }

        // Vérifier si le recruteur est validé
        if ($user->role === 'recruiter' && !$user->is_validated) {
            return redirect()->route('home')->withErrors(['error' => 'Votre compte recruteur est en attente de validation par un administrateur.']);
        }

        return $next($request);
    }
}
