<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Permite el acceso a usuarios con rol 'admin' o 'advanced'.
 * Ambos pueden crear y gestionar paquetes vacacionales.
 */
class AdvancedMiddleware {
    public function handle(Request $request, Closure $next) {
        if (Auth::check() && in_array(Auth::user()->rol, ['admin', 'advanced'])) {
            return $next($request);
        }
        abort(403, 'Acceso denegado');
    }
}