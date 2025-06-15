<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Images;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductoApiController extends Controller
{
    // LISTAR todos los productos con su imagen
    public function index()
    {
        $productos = Producto::with('images')->get();
        return response()->json($productos, Response::HTTP_OK);
    }

    // CREAR un producto y subir su imagen
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emprendimientos_id'      => 'required|integer|exists:emprendimientos,emprendimientos_id',
            'categorias_productos_id'    => 'required|integer|exists:categorias_productos,categorias_productos_id',
            'nombre' => 'required|string|max:150',
            'descripcion'     => 'nullable|string',
            'precio'          => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'imagen'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado'          => 'nullable|in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // 1) Creamos el producto
        $prod = Producto::create([
            'emprendimientos_id'      => $request->emprendimientos_id,
            'categorias_productos_id' => $request->categorias_productos_id,
            'nombre'                  => $request->nombre,          // <-- usa 'nombre'
            'descripcion'             => $request->descripcion,
            'precio'                  => $request->precio,
            'stock'                   => $request->stock,
            // NO incluyo 'imagen' aún
        ]);

        // 2) Si envían imagen, la almacenamos y relacionamos
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');

            $prod->imagen = $path;
            $prod->save();

            $img = Images::create([
                'url'    => $path,
                'titulo' => $prod->nombre,   // <-- aquí debes usar $prod->nombre
            ]);

            DB::table('imageables')->insert([
                'images_id'      => $img->id,
                'imageable_id'   => $prod->productos_id,
                'imageable_type' => Producto::class,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // Recargamos la relación para devolverla
        $prod->load('images');

        return response()->json([
            'message'  => 'Producto creado correctamente',
            'producto' => $prod
        ], Response::HTTP_CREATED);
    }

    // MOSTRAR un producto específico
    public function show($id)
    {
        $prod = Producto::with('images')->findOrFail($id);
        return response()->json($prod, Response::HTTP_OK);
    }

    // ACTUALIZAR producto y opcionalmente cambiar imagen
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:150',
            'descripcion'     => 'nullable|string',
            'precio'          => 'sometimes|required|numeric|min:0',
            'stock'           => 'sometimes|required|integer|min:0',
            'imagen'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado'          => 'nullable|in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $prod = Producto::findOrFail($id);
        $prod->update($request->only('nombre', 'descripcion', 'precio', 'stock'));

        if ($request->hasFile('imagen')) {
            // (Opcional) podrías eliminar la imagen anterior aquí…

            $path = $request->file('imagen')->store('productos', 'public');
            $img = Images::create([
                'url'    => $path,
                'titulo' => $prod->nombre_producto,
            ]);

            DB::table('imageables')->insert([
                'images_id'      => $img->id,
                'imageable_id'   => $prod->id_producto,
                'imageable_type' => Producto::class,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        $prod->load('images');

        return response()->json([
            'message'  => 'Producto actualizado correctamente',
            'producto' => $prod
        ], Response::HTTP_OK);
    }

    // ELIMINAR producto (y sus imágenes en pivote por cascade)
    public function destroy($id)
    {
        $prod = Producto::findOrFail($id);
        $prod->delete();
        return response()->json(['message' => 'Producto eliminado correctamente'], Response::HTTP_OK);
    }
}
