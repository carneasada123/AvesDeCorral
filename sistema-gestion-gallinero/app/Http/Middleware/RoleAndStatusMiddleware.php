<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class RoleAndStatusMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Verificar si el estado del usuario es activo
            if ($user->fk_estado != 1) {
                return response()->json(['error' => 'Usuario inactivo'], 403);
            }

            // Verificar si el rol del usuario coincide con el rol esperado
            if ($user->fk_rol != $role) {
                return response()->json(['error' => 'Acceso no autorizado'], 403);
            }

        } catch (TokenExpiredException $e) {
            return redirect('/')->with('error', 'La sesión ha expirado. Inicia sesión nuevamente.');
        } catch (TokenInvalidException $e) {
            return redirect('/')->with('error', 'Token inválido. Inicia sesión nuevamente.');
        } catch (JWTException $e) {
            return redirect('/')->with('error', 'Token ausente. Inicia sesión para continuar.');
        }

        return $next($request);
    }
}
