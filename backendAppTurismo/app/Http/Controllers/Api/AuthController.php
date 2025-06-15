<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail; // Asegúrate de crear este Mailable

class AuthController extends Controller
{
    /**
     * Verificar si existe email y devolver nombre y roles.
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'name' => $user->name,
                'roles' => $user->getRoleNames()
            ]);
        } else {
            return response()->json([
                'exists' => false,
                'name' => null,
                'roles' => []
            ]);
        }
    }

    /**
     * Registro de usuario.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = new User([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        $user->setUserCode();
        $user->save();
        $user->assignRole('Usuario');

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'token' => $token,
            'id' => $user->id,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'roles' => $user->getRoleNames(),
        ], 201);
    }

    /**
     * Login tradicional solo con correo electrónico.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'error' => 'Usuario inactivo',
                'motivo' => $user->motivo_inactivo ?? 'Sin especificar'
            ], 403);
        }

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'token' => $token,
            'id' => $user->id,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'roles' => $user->getRoleNames(),
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


    /**
     * Enviar correo para restablecer contraseña (solicitud)
     */
    public function sendResetPasswordEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

        return response()->json(['message' => 'Correo para restablecer contraseña enviado']);
    }

    /**
     * Restablecer la contraseña (confirmar cambio)
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return response()->json(['error' => 'Token no encontrado o inválido'], 400);
        }

        if (!Hash::check($request->token, $record->token)) {
            return response()->json(['error' => 'Token inválido'], 400);
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['error' => 'Token expirado'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Contraseña actualizada con éxito']);
    }
}
