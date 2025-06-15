<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ZonaTuristica;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class ZonaTuristicaApiController extends Controller
{
    // 1. Listar con imágenes
    public function index()
    {
        $zonas = ZonaTuristica::with('images')->get();
        return response()->json($zonas, Response::HTTP_OK);
    }

    // 2. Crear con imagen
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'ubicacion'   => 'nullable|string|max:255',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado'      => 'in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        // Crea la zona sin la imagen
        $zona = ZonaTuristica::create($request->only('nombre','descripcion','ubicacion','estado'));

        // Si viene archivo, lo guarda y relaciona
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('zonas', 'public');

            $imagen = Images::create([
                'url'    => $path,
                'titulo' => $zona->nombre,
            ]);

            DB::table('imageables')->insert([
                'images_id'      => $imagen->id,
                'imageable_id'   => $zona->zonas_turisticas_id,
                'imageable_type' => ZonaTuristica::class,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
        $zona->load('images');
        return response()->json([
            'message' => 'Zona turística creada correctamente',
            'zona'    => $zona->load('images')
        ], Response::HTTP_CREATED);
    }

    // 3. Mostrar una
    public function show($id)
    {
        $zona = ZonaTuristica::with('images')->findOrFail($id);
        return response()->json($zona, Response::HTTP_OK);
    }

    // 4. Actualizar (y opcionalmente cambiar imagen)
    public function update(Request $request, $id)
    {
        $zona = ZonaTuristica::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'ubicacion'   => 'nullable|string|max:255',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado'      => 'in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $zona->update($request->only('nombre','descripcion','ubicacion','estado'));

        if ($request->hasFile('imagen')) {
            // (Opcional) borrar imágenes previas si lo deseas…

            $path = $request->file('imagen')->store('zonas', 'public');
            $imagen = Images::create([
                'url'    => $path,
                'titulo' => $zona->nombre,
            ]);
            DB::table('imageables')->insert([
                'images_id'      => $imagen->id,
                'imageable_id'   => $zona->zonas_turisticas_id,
                'imageable_type' => ZonaTuristica::class,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
        $zona->load('images');

        return response()->json([
            'message' => 'Zona turística actualizada correctamente',
            'zona'    => $zona->load('images')
        ], Response::HTTP_OK);
    }

    // 5. Eliminar
    public function destroy($id)
    {
        $zona = ZonaTuristica::findOrFail($id);
        $zona->delete();
        return response()->json(['message'=>'Zona turística eliminada correctamente'], Response::HTTP_OK);
    }
}
