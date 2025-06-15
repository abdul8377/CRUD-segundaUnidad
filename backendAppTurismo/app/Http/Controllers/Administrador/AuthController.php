<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registro de usuario.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        // Asignar un rol por defecto (opcional si usas Spatie)
        $user->assignRole('Usuario');  // Puedes ajustar según tu lógica de roles

        // Iniciar sesión automáticamente
        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'token' => $token,
            'name' => $user->name,
            'role' => $user->getRoleNames()->first() ?? 'Usuario'  // Asumiendo que usas Spatie
        ], 201);
    }

    /**
     * Login tradicional con correo o nombre de usuario.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_gmail' => 'required|string',  // Correo o nombre de usuario
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Intentamos encontrar al usuario usando correo o nombre de usuario
        $user = User::where('email', $request->email_or_gmail)
                    ->orWhere('name', $request->email_or_gmail)
                    ->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Verificar la contraseña
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Verificar si el usuario está inactivo
        if (!$user->is_active) {
            return response()->json([
                'error' => 'Usuario inactivo',
                'motivo' => $user->motivo_inactivo ?? 'Sin especificar'
            ], 403);
        }

        // Generar el token de acceso
        $token = $user->createToken('MyApp')->plainTextToken;

        // Devolver los datos del usuario junto con el token
        return response()->json([
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getRoleNames()->first(),
            'is_active' => $user->is_active,
            'motivo_inactivo' => $user->motivo_inactivo
        ], 200);
    }

    /**
     * Logout de usuario.
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Desconectado con éxito'], 200);
    }
}
