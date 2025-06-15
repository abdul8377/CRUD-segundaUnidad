<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryProductsApiController extends Controller
{
    // Listar todas las categorías
    public function index()
    {
        $cats = CategoriaProducto::all();
        return response()->json($cats, Response::HTTP_OK);
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        if ($v->fails()) {
            return response()->json(['errors'=>$v->errors()], 422);
        }

        $cat = CategoriaProducto::create($v->validated());

        return response()->json([
            'message'   => 'Categoría creada correctamente',
            'categoria' => $cat
        ], Response::HTTP_CREATED);
    }

    // Mostrar una categoría
    public function show($id)
    {
        $cat = CategoriaProducto::findOrFail($id);
        return response()->json($cat, Response::HTTP_OK);
    }

    // Actualizar una categoría
    public function update(Request $request, $id)
    {
        $cat = CategoriaProducto::findOrFail($id);

        $v = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        if ($v->fails()) {
            return response()->json(['errors'=>$v->errors()], 422);
        }

        $cat->update($v->validated());

        return response()->json([
            'message'   => 'Categoría actualizada correctamente',
            'categoria' => $cat
        ], Response::HTTP_OK);
    }

    // Eliminar una categoría
    public function destroy($id)
    {
        $cat = CategoriaProducto::findOrFail($id);
        $cat->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente'
        ], Response::HTTP_OK);
    }
}
