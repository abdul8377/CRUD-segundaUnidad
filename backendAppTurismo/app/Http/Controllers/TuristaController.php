<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TuristaController extends Controller
{
    // Mostrar la lista de turistas con rol 'Usuario'
    public function index()
    {
        // Obtener todos los usuarios que tienen el rol 'Usuario' usando Spatie
        $turistas = User::role('Usuario')->get();

        return view('Turista.index', compact('turistas'));
    }

    // Mostrar los detalles completos de un turista
    public function show(User $turista)
    {
        return view('Turista.show', compact('turista'));
    }

    // Mostrar el formulario para editar la contraseña de un turista
    public function edit(User $turista)
    {
        return view('Turista.edit', compact('turista'));
    }

    // Actualizar la contraseña de un turista
    public function update(Request $request, User $turista)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $turista->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('turistas.index')->with('success', 'Contraseña actualizada correctamente');
    }
}
