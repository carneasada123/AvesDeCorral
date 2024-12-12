<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
    // Verifica si la solicitud espera una respuesta JSON (lo común en las rutas API)
    if ($request->expectsJson()) {
        abort(response()->json(['error' => 'No autenticado. Por favor, inicia sesión.'], 401));
    }

    // Si no es una solicitud API, puedes redirigir al login en rutas web
    return route('login');
    }
}
