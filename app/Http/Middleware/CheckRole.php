<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!Auth::check() || Auth::user()->rol !== $rol) {
            // Redirigir al dashboard que le corresponde según su rol
            if (Auth::check()) {
                return match (Auth::user()->rol) {
                    'administrador' => redirect()->route('admin.home'),
                    'veterinario' => redirect()->route('home'),
                    default => redirect()->route('login'),
                };
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
