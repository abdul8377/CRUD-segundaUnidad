<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoDeNegocio;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoDeNegocioController extends Controller
{
    // Listar todos los tipos de negocio con la cantidad de emprendimientos vinculados
    public function index(Request $request)
    {
        $searchQuery = $request->query('search', '');

        $tiposDeNegocio = TipoDeNegocio::withCount('emprendimientos')
            ->where('nombre', 'like', '%' . $searchQuery . '%')
            ->orWhere('descripcion', 'like', '%' . $searchQuery . '%')
            ->get();

        return response()->json($tiposDeNegocio);
    }

    // Ver un tipo de negocio específico (y los emprendimientos vinculados)
    public function show($id)
    {
        $tipoDeNegocio = TipoDeNegocio::with('emprendimientos')->find($id);

        if (!$tipoDeNegocio) {
            return response()->json(['message' => 'Tipo de negocio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($tipoDeNegocio);
    }

    // Obtener los emprendimientos vinculados a un tipo de negocio específico
    public function getEmprendimientosByTipo($id)
    {
        $tipoDeNegocio = TipoDeNegocio::with('emprendimientos')->find($id);

        if (!$tipoDeNegocio) {
            return response()->json(['message' => 'Tipo de negocio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Regresamos los emprendimientos vinculados al tipo de negocio
        return response()->json($tipoDeNegocio->emprendimientos);
    }

    // Crear un nuevo tipo de negocio
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipoDeNegocio = TipoDeNegocio::create($validated);

        return response()->json($tipoDeNegocio, Response::HTTP_CREATED);
    }

    // Editar un tipo de negocio existente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipoDeNegocio = TipoDeNegocio::find($id);

        if (!$tipoDeNegocio) {
            return response()->json(['message' => 'Tipo de negocio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $tipoDeNegocio->update($validated);

        return response()->json($tipoDeNegocio);
    }

    // Eliminar un tipo de negocio solo si no tiene emprendimientos vinculados
    public function destroy($id)
    {
        $tipoDeNegocio = TipoDeNegocio::find($id);

        if (!$tipoDeNegocio) {
            return response()->json(['message' => 'Tipo de negocio no encontrado'], Response::HTTP_NOT_FOUND);
        }

        if ($tipoDeNegocio->emprendimientos_count > 0) {
            return response()->json(['message' => 'No se puede eliminar este tipo de negocio, ya que tiene emprendimientos vinculados'], Response::HTTP_BAD_REQUEST);
        }

        $tipoDeNegocio->delete();

        return response()->json(['message' => 'Tipo de negocio eliminado correctamente']);
    }
}
