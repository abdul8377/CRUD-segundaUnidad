<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Imageable;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageableController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imageable_id' => 'required|integer',
            'imageable_type' => 'required|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titulo' => 'nullable|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Subir archivo
        $filePath = $request->file('file')->store('imagenes', 'public');

        // Crear imagen
        $imagen = Images::create([
            'url' => $filePath,
            'titulo' => $request->titulo,

        ]);

        // Crear relación polimórfica
        Imageable::create([
            'imagen_id' => $imagen->id,
            'imageable_id' => $request->imageable_id,
            'imageable_type' => $request->imageable_type,
        ]);

        return response()->json([
            'message' => 'Imagen subida correctamente',
            'imagen' => $imagen
        ], 201);
    }

    public function index($type, $id)
    {
        $model = 'App\\Models\\' . ucfirst($type);
        if (!class_exists($model)) {
            return response()->json(['error' => 'Modelo no encontrado'], 404);
        }

        $item = $model::find($id);
        if (!$item) {
            return response()->json(['error' => 'Elemento no encontrado'], 404);
        }

        return response()->json($item->imagenes, 200);
    }

}
