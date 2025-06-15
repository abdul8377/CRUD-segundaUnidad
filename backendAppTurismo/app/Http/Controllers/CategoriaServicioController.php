<?php

namespace App\Http\Controllers;

use App\Models\CategoriaServicio;
use Illuminate\Http\Request;

class CategoriaServicioController extends Controller
{
    // Mostrar la lista de categorías de servicio
    public function index()
    {
        // Obtener todas las categorías de servicio con el número de servicios asociados
        $categorias = CategoriaServicio::withCount('servicios')->get();

        return view('CategoriaServicio.index', compact('categorias'));
    }

    // Mostrar los detalles de una categoría de servicio
    public function show($id)
{
    $categoria = CategoriaServicio::find($id); // Esto es más explícito que el enlace del modelo

    if (!$categoria) {
        return redirect()->route('categorias-servicios.index')->with('error', 'Categoría no encontrada.');
    }

    $categoria->load('servicios'); // Cargar servicios vinculados

    return view('CategoriaServicio.show', compact('categoria'));
}





    // Mostrar el formulario para crear una nueva categoría de servicio
    public function create()
    {
        return view('CategoriaServicio.create');
    }

    // Guardar una nueva categoría de servicio
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Crear una nueva categoría de servicio
        CategoriaServicio::create($validated);

        return redirect()->route('categorias-servicios.index')->with('success', 'Categoría de servicio creada correctamente');
    }

    // Mostrar el formulario para editar una categoría de servicio
    public function edit(CategoriaServicio $categoriaDeServicio)
    {
        // Aquí, $categoriaDeServicio es automáticamente inyectado por Laravel
        return view('CategoriaServicio.edit', compact('categoriaDeServicio'));
    }


    // Actualizar la categoría de servicio
    public function update(Request $request, CategoriaServicio $categoriaDeServicio)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Actualizar la categoría de servicio
        $categoriaDeServicio->update($validated);

        return redirect()->route('categorias-servicios.index')->with('success', 'Categoría de servicio actualizada correctamente');
    }

}
