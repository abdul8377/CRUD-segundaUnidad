<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // Listar usuarios con filtro por rol y estado
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role')) {
            $role = $request->input('role');
            // Si usas Spatie
            $query->role($role);
            // O si tienes relación roles, puedes usar whereHas
            // $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        $users = $query->with('roles')->get();  // cargar roles si tienes relación

        return response()->json($users);
    }

    // Cambiar estado activo/inactivo con motivo
    public function toggleActive(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
            'motivo_inactivo' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->is_active = $request->is_active;
        $user->motivo_inactivo = $request->is_active ? null : $request->motivo_inactivo;
        $user->save();

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'user' => $user,
        ]);
    }

    // Cambiar contraseña (el usuario debe enviar la nueva contraseña)
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada']);
    }

        // Obtener un usuario individual por ID
    public function show($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }

}
