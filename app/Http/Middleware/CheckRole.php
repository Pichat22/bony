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
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        // Redirige avec un message d'alerte
        return redirect()
            ->route('dashboard') // Remplacez par le nom de la route des réservations
            ->with('error', 'Accès interdit. Vous avez été redirigé vers vos réservations.');
    }
}


