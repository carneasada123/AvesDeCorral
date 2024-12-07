<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;  // Asegúrate de importar el modelo Persona
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'usuario' => 'required|string',
                'clave' => 'required|string',
            ]);

            // Intentar autenticar al usuario
            $user = Usuario::where('usuario', $request->usuario)->first();

            if (!$user || !Hash::check($request->clave, $user->clave)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }

            // Validar el estado del usuario antes de emitir el token
            if ($user->fk_estado != 1) { // 1 representa "Activo"
                return response()->json(['error' => 'Usuario inactivo comuniquese con el administrador'], 403);
            }

            $usuarioToken = JWTAuth::claims(['usuario' => $user->usuario])->fromUser($user);

            // Emitir los tokens solo si el usuario está activo
            $loginToken = JWTAuth::fromUser($user);
            $roleToken = JWTAuth::claims(['role' => $user->fk_rol])->fromUser($user);
            $statusToken = JWTAuth::claims(['status' => $user->fk_estado])->fromUser($user);

            return response()->json([
                'login_token' => $loginToken,
                'role_token' => $roleToken,
                'status_token' => $statusToken,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);

            $decodedRoleToken = JWTAuth::setToken($roleToken)->getPayload();
            \Log::info('Contenido de roleToken:', ['roleToken' => $decodedRoleToken]);


        } catch (\Exception $e) {
            \Log::error('Error en el inicio de sesión: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error inesperado'], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // Validación de los campos
            $request->validate([
                'usuario' => 'required|string|max:255|unique:usuarios',
                'clave' => 'required|string|min:6',
                'nombre' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'nullable|string|max:255',
                'fk_rol' => 'required|integer|exists:roles,id_rol',
                'fk_estado' => 'required|integer|exists:estados,id_estado',
            ]);

            // Crear la persona
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido_paterno = $request->apellido_paterno;
            $persona->apellido_materno = $request->apellido_materno;
            $persona->save();

            // Crear el usuario
            $usuario = new Usuario();
            $usuario->usuario = $request->usuario;
            $usuario->clave = $request->clave;  // Utiliza el mutador para encriptar
            $usuario->fk_persona = $persona->id_persona;
            $usuario->fk_rol = $request->fk_rol;
            $usuario->fk_estado = $request->fk_estado;
            $usuario->save();

            return response()->json(['message' => 'Usuario registrado correctamente'], 201);
        } catch (\Exception $e) {
            \Log::error('Error en el registro de usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Por favor llene los campos correctamente segun las indicaciones.'], 500);
        }
    }
}
