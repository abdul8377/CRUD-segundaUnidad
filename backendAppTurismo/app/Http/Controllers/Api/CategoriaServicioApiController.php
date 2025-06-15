<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaServicio;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaServicioApiController extends Controller
{
    // Mostrar la lista de categorías de servicio
    public function index()
    {
        try {
            $categorias = CategoriaServicio::with(['images'])
                ->get();
            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Error al obtener las categorías de servicio',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $categoria = CategoriaServicio::with('images')->findOrFail($id);
            return response()->json($categoria, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Categoría de servicio no encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la categoría de servicio', 'message' => $e->getMessage()], 500);
        }
    }

    // Crear una nueva categoría de servicio
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icono'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 1) Prepara el array de datos
        $data = [
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
        ];

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('categorias', 'public');
            $data['imagen'] = $path;
        }

        if ($request->hasFile('icono')) {
            $path = $request->file('icono')->store('icons', 'public');
            $data['icono'] = $path;
        }

        // 4) Crea la categoría con nombre, descripción, imagen e icono
        $categoria = CategoriaServicio::create($data);

        // 5) Ahora guarda en images + pivote si lo deseas
        if (isset($data['imagen'])) {
            $imagen = Images::create([
                'url'    => $data['imagen'],
                'titulo' => $categoria->nombre,
            ]);
            DB::table('imageables')->insert([
                'images_id'      => $imagen->id,
                'imageable_id'   => $categoria->categorias_servicios_id,
                'imageable_type' => CategoriaServicio::class,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        if (isset($data['icono'])) {
            $icono = Images::create([
                'url'    => $data['icono'],
                'titulo' => $categoria->nombre . ' (Icono)',
            ]);
            DB::table('imageables')->insert([
                'images_id'      => $icono->id,
                'imageable_id'   => $categoria->categorias_servicios_id,
                'imageable_type' => CategoriaServicio::class,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        $categoria->load(['images']);
        return response()->json($categoria, 201);
    }

    // Actualizar la categoría de servicio
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'icono' => 'nullable|string',
            ]);

            $categoria = CategoriaServicio::findOrFail($id);
            $categoria->update($validated);

            return response()->json($categoria, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Categoría de servicio no encontrada'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Error de validación', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la categoría de servicio', 'message' => $e->getMessage()], 500);
        }
    }

    // Eliminar una categoría de servicio
    public function destroy($id)
    {
        try {
            $categoria = CategoriaServicio::findOrFail($id);
            $categoria->delete();

            return response()->json(['message' => 'Categoría de servicio eliminada correctamente'], 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Categoría de servicio no encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la categoría de servicio', 'message' => $e->getMessage()], 500);
        }
    }
}
