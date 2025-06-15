<?php

namespace App\Http\Controllers\ProductoServicio;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\EmprendimientoUsuario;
use App\Models\CategoriaServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $emprendimiento = EmprendimientoUsuario::where('users_id', $userId)->first();

        if (!$emprendimiento) {
            return redirect()->back()->with('error', 'No tienes un emprendimiento vinculado.');
        }

        $servicios = Servicio::with('categoria')
            ->where('emprendimientos_id', $emprendimiento->emprendimientos_id)
            ->get();

        return view('ProductoServicio.servicios.index', compact('servicios'));
    }

    public function create()
    {
        $categorias = CategoriaServicio::all();
        return view('ProductoServicio.servicios.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'capacidad_maxima' => 'required|integer|min:1',
            'duracion_servicio' => 'nullable|integer|min:1',
            'imagen_destacada' => 'nullable|string|max:255',
            'categorias_servicios_id' => 'required|exists:categorias_servicios,categorias_servicios_id',
        ]);

        $userId = Auth::id();
        $emprendimientoUsuario = EmprendimientoUsuario::where('users_id', $userId)->first();

        if (!$emprendimientoUsuario) {
            return redirect()->back()->with('error', 'No tienes un emprendimiento vinculado.');
        }

        Servicio::create([
            'emprendimientos_id' => $emprendimientoUsuario->emprendimientos_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'capacidad_maxima' => $request->capacidad_maxima,
            'duracion_servicio' => $request->duracion_servicio,
            'imagen_destacada' => $request->imagen_destacada,
            'categorias_servicios_id' => $request->categorias_servicios_id,
        ]);

        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function edit(Servicio $servicio)
    {
        $categorias = CategoriaServicio::all();
        return view('ProductoServicio.servicios.edit', compact('servicio', 'categorias'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'capacidad_maxima' => 'required|integer|min:1',
            'duracion_servicio' => 'nullable|integer|min:1',
            'imagen_destacada' => 'nullable|string|max:255',
            'categorias_servicios_id' => 'required|exists:categorias_servicios,categorias_servicios_id',
        ]);

        $servicio->update($request->all());

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}
