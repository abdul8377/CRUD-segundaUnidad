<?php

namespace App\Http\Controllers\ProductoServicio;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProducto;
use Illuminate\Http\Request;

class CategoriaProductoController extends Controller
{
    // Mostrar la lista de categorías de productos
    public function index()
    {
        // Obtener todas las categorías de productos con el número de productos asociados
        $categorias = CategoriaProducto::withCount('productos')->get();

        return view('ProductoServicio.CategoriaProducto.index', compact('categorias'));
    }

    // Mostrar los detalles de una categoría de producto
    public function show($id)
    {
        // Buscar la categoría de producto con sus productos asociados
        $categoria = CategoriaProducto::with('productos')->find($id);

        // Si la categoría no existe, redirigir con un mensaje de error
        if (!$categoria) {
            return redirect()->route('categorias-productos.index')->with('error', 'Categoría no encontrada.');
        }

        return view('ProductoServicio.CategoriaProducto.show', compact('categoria'));
    }

    // Mostrar el formulario para crear una nueva categoría de producto
    public function create()
    {
        return view('ProductoServicio.CategoriaProducto.create');
    }

    // Guardar una nueva categoría de producto
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Crear una nueva categoría de producto
        CategoriaProducto::create($validated);

        // Redirigir a la lista de categorías con un mensaje de éxito
        return redirect()->route('categorias-productos.index')->with('success', 'Categoría de producto creada correctamente');
    }

    // Mostrar el formulario para editar una categoría de producto
    public function edit(CategoriaProducto $categoriaProducto)
    {
        // Esto pasará el modelo de la categoría de producto para que pueda ser editado
        return view('ProductoServicio.CategoriaProducto.edit', compact('categoriaProducto'));
    }

    // Actualizar una categoría de producto
    public function update(Request $request, CategoriaProducto $categoriaProducto)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Actualizar la categoría de producto
        $categoriaProducto->update($validated);

        // Redirigir a la lista de categorías con un mensaje de éxito
        return redirect()->route('categorias-productos.index')->with('success', 'Categoría de producto actualizada correctamente');
    }

    // Eliminar una categoría de producto (opcional)
    public function destroy(CategoriaProducto $categoriaProducto)
    {
        // Eliminar la categoría de producto
        $categoriaProducto->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('categorias-productos.index')->with('success', 'Categoría de producto eliminada correctamente');
    }
}
