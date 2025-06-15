<?php

namespace App\Http\Controllers\EmprendimientoUsuario;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use App\Models\EmprendimientoUsuario;
use App\Models\User;
use App\Models\Image;  // Asegúrate de importar el modelo de Image
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;  // Importar Str

class EmprendimientoUsuarioController extends Controller
{
    /**
     * Mostrar el formulario para crear el emprendimiento y asignar un usuario.
     */
    public function create($emprendedor_id)
    {
        // Obtener el usuario emprendedor por su ID
        $emprendedor = User::findOrFail($emprendedor_id);

        // Obtener la lista de todos los tipos de negocio
        $tiposDeNegocio = \App\Models\TipoDeNegocio::all();  // Asegúrate de que exista el modelo TipoDeNegocio

        // Retornar la vista con el usuario y los tipos de negocio
        return view('EmprendimientoUsuario.create', compact('emprendedor', 'tiposDeNegocio'));
    }

    /**
     * Almacenar el emprendimiento y asignar un usuario y rol.
     */
    // Controlador EmprendimientoUsuarioController
public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'direccion' => 'nullable|string|max:255',
        'telefono' => 'nullable|string|max:20',
        'imagen_destacada' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'rol_emprendimiento' => 'required|in:propietario,colaborador',
        'tipo_negocio_id' => 'required|exists:tipos_de_negocio,id',
    ]);


    $estado = 'activo';

    // Crear el emprendimiento, incluyendo el tipo_negocio_id
    $emprendimiento = Emprendimiento::create([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'estado' => $estado,
        'tipo_negocio_id' => $request->tipo_negocio_id,
    ]);

    // Subir la imagen destacada si existe
    if ($request->hasFile('imagen_destacada')) {
        $imagen_url = $request->file('imagen_destacada')->store('emprendedores', 'public');
        $imagePath = str_replace('public/', '', $imagen_url);

        // Crear y guardar la imagen con la ruta almacenada
        $emprendimiento->image()->create([
            'url' => $imagePath,  // Ruta relativa para guardar en la base de datos
        ]);
    }

    // Asignar el usuario y el rol al emprendimiento
    EmprendimientoUsuario::create([
        'emprendimientos_id' => $emprendimiento->emprendimientos_id,  // Usamos emprendimientos_id
        'users_id' => $request->usuario_id ?? $emprendimiento->emprendedor_id,
        'rol_emprendimiento' => $request->rol_emprendimiento,
    ]);

    // Redirigir a la vista de emprendedores con un mensaje de éxito
    return redirect()->route('emprendedores.index')->with('success', 'Emprendimiento creado y usuario asignado correctamente.');
}



}
