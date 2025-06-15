<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmprendedorController extends Controller
{
    // Mostrar lista de emprendedores
    public function index()
    {
        $emprendedores = User::whereHas('perfilEmprendedor')
            ->with(['perfilEmprendedor', 'emprendimientoUsuarios'])
            ->get();

        return view('Emprendedor.index', compact('emprendedores'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $countries = DB::table('lc_countries')
            ->join('lc_countries_translations', 'lc_countries.id', '=', 'lc_countries_translations.lc_country_id')
            ->where('lc_countries_translations.locale', 'es')
            ->whereNotNull('lc_countries.iso_alpha_2')
            ->where('lc_countries.is_visible', true)
            ->orderBy('lc_countries_translations.name')
            ->pluck('lc_countries_translations.name', 'lc_countries.iso_alpha_2')
            ->toArray();

        return view('Emprendedor.create', compact('countries'));
    }

    // Guardar usuario y perfil
    public function store(Request $request)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user' => 'required|string|max:100|unique:users,user',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'country' => 'required|string|max:2',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validatedUser['name'],
            'last_name' => $validatedUser['last_name'],
            'user' => $validatedUser['user'],
            'email' => $validatedUser['email'],
            'password' => Hash::make($validatedUser['password']),
            'country' => $validatedUser['country'],
            'zip_code' => $validatedUser['zip_code'],
        ]);

        $user->assignRole('Emprendedor');

        $validatedProfile = $request->validate([
            'dni' => 'required|string|max:20',
            'telefono_contacto' => 'nullable|string|max:20',
            'gmail_contacto' => 'nullable|string|email|max:255',
            'experiencia' => 'nullable|string',
        ]);

        $user->perfilEmprendedor()->create($validatedProfile);

        return redirect()->route('emprendedores.index')->with('success', 'Emprendedor creado correctamente');
    }

    // Mostrar detalles de un emprendedor
    public function show(User $emprendedor)
    {
        $emprendedor->load('emprendimientos');
        return view('Emprendedor.show', compact('emprendedor'));
    }

    // Mostrar formulario de edición
    public function edit(User $emprendedor)
    {
        $emprendedor->load('perfilEmprendedor');

        $countries = DB::table('lc_countries')
            ->join('lc_countries_translations', 'lc_countries.id', '=', 'lc_countries_translations.lc_country_id')
            ->where('lc_countries_translations.locale', 'es')
            ->whereNotNull('lc_countries.iso_alpha_2')
            ->where('lc_countries.is_visible', true)
            ->orderBy('lc_countries_translations.name')
            ->pluck('lc_countries_translations.name', 'lc_countries.iso_alpha_2')
            ->toArray();

        return view('Emprendedor.edit', compact('emprendedor', 'countries'));
    }

    // Actualizar perfil del emprendedor
    public function update(Request $request, User $emprendedor)
    {
        $validatedProfile = $request->validate([
            'dni' => 'required|string|max:20',
            'telefono_contacto' => 'nullable|string|max:20',
            'gmail_contacto' => 'nullable|string|email|max:255',
            'experiencia' => 'nullable|string',
        ]);

        $emprendedor->perfilEmprendedor->update($validatedProfile);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $emprendedor->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('emprendedores.index')->with('success', 'Perfil actualizado correctamente');
    }

    // Actualizar estado de validación
    public function updateStatus(Request $request, User $emprendedor)
    {
        $validated = $request->validate([
            'estado_validacion' => 'required|in:pendiente,aprobado,rechazado',
        ]);

        $emprendedor->perfilEmprendedor->update([
            'estado_validacion' => $validated['estado_validacion'],
        ]);

        return redirect()->route('emprendedores.show', $emprendedor)
                         ->with('success', 'Estado de validación actualizado correctamente.');
    }
}
