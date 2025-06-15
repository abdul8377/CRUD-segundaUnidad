<?php

namespace App\Http\Controllers\ApiEmprendedor;

use App\Http\Controllers\Controller;
use App\Models\CategoriaServicio;
use App\Models\CategoriaProducto;
use Illuminate\Http\JsonResponse;

class ApiCategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        $categoriasServicios = CategoriaServicio::all();
        $categoriasProductos = CategoriaProducto::all();

        return response()->json([
            'servicios' => $categoriasServicios,
            'productos' => $categoriasProductos
        ], 200);
    }

    public function productosPorCategoria(int $id): JsonResponse
    {
        $categoria = CategoriaProducto::with(['productos.emprendimiento'])->find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría de producto no encontrada'], 404);
        }

        return response()->json([
            'categoria' => $categoria->nombre,
            'productos' => $categoria->productos
        ], 200);
    }

    public function serviciosPorCategoria(int $id): JsonResponse
    {
        $categoria = CategoriaServicio::with(['servicios.emprendimiento'])->find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría de servicio no encontrada'], 404);
        }

        return response()->json([
            'categoria' => $categoria->nombre,
            'servicios' => $categoria->servicios
        ], 200);
    }
}
