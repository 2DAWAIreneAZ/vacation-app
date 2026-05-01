<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Solo permite el acceso a usuarios con rol 'admin'.
 */
class AdminMiddleware {
    public function handle(Request $request, Closure $next) {
        if (Auth::check() && Auth::user()->rol === 'admin') {
            return $next($request);
        }
        abort(403, 'Acceso denegado');
    }
}