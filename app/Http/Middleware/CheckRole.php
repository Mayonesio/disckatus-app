<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no hay usuario autenticado, redirigir al login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Si no se especificaron roles, continuar
        if (empty($roles)) {
            return $next($request);
        }

        // Si el usuario tiene alguno de los roles especificados, continuar
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Si el usuario no tiene los roles necesarios
        return redirect()->back()
            ->with('error', 'No tienes permisos suficientes para acceder a esta sección.');
    }
}