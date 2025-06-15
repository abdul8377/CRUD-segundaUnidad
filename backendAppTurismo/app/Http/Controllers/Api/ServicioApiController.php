<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Images;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ServicioApiController extends Controller
{
    public function index(Request $request)
    {
        $tipoNegocioId = $request->input('tipo_negocio_id');

        $query = Servicio::with(['emprendimiento', 'images']);

        if ($tipoNegocioId) {
            $query->whereHas('emprendimiento', function ($q) use ($tipoNegocioId) {
                $q->where('tipo_negocio_id', $tipoNegocioId);
            });
        }

        $servicios = $query->get();

        return response()->json($servicios, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emprendimientos_id'      => 'required|integer|exists:emprendimientos,emprendimientos_id',
            'nombre'                  => 'required|string|max:150',
            'descripcion'             => 'nullable|string',
            'precio'                  => 'required|numeric|min:0',
            'capacidad_maxima'        => 'required|integer|min:1',
            'duracion_servicio'       => 'nullable|string',
            'imagenes.*'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 1) Crear el servicio sin imágenes
        $data = $validator->validated();
        unset($data['imagenes']);
        $servicio = Servicio::create($data);

        // 2) Si llegaron archivos en 'imagenes[]', guardarlos y asociar
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                // Guardar en disco bajo “servicios/{id}/...”
                $path = $file->store("servicios/{$servicio->getKey()}", 'public');

                // Crear registro en tabla `images`
                $img = Images::create([
                    'url'    => $path,
                    'titulo' => $servicio->nombre . ' (Imagen)',
                ]);

                // Insertar en pivote `imageables`
                DB::table('imageables')->insert([
                    'images_id'      => $img->id,
                    'imageable_id'   => $servicio->getKey(),
                    'imageable_type' => Servicio::class,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        // 3) Precargamos relaciones y devolvemos
        $servicio->load(['emprendimiento', 'images']);
        return response()->json([
            'message'  => 'Servicio creado correctamente',
            'servicio' => $servicio
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/servicios/{id}
     * Muestra un servicio específico
     */
    public function show($id)
    {
        $servicio = Servicio::with(['emprendimiento', 'images'])
            ->findOrFail($id);

        return response()->json($servicio, Response::HTTP_OK);
    }

    /**
     * PUT /api/servicios/{id}
     * Actualiza un servicio y, opcionalmente, agrega nuevas imágenes
     */
    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'emprendimientos_id'      => 'sometimes|required|integer|exists:emprendimientos,emprendimientos_id',
            'nombre'                  => 'sometimes|required|string|max:150',
            'descripcion'             => 'nullable|string',
            'precio'                  => 'sometimes|required|numeric|min:0',
            'capacidad_maxima'        => 'sometimes|required|integer|min:1',
            'duracion_servicio'       => 'nullable|string',
            'imagenes.*'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 1) Actualizar campos del servicio
        $data = $validator->validated();
        unset($data['imagenes']);
        $servicio->update($data);

        // 2) Si enviaron nuevos archivos en 'imagenes[]', guardarlos y vincularlos
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                $path = $file->store("servicios/{$servicio->getKey()}", 'public');
                $img  = Images::create([
                    'url'    => $path,
                    'titulo' => $servicio->nombre . ' (Imagen)',
                ]);
                DB::table('imageables')->insert([
                    'images_id'      => $img->id,
                    'imageable_id'   => $servicio->getKey(),
                    'imageable_type' => Servicio::class,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        // 3) Devolver con relaciones recargadas
        $servicio->load(['emprendimiento', 'images']);
        return response()->json([
            'message'  => 'Servicio actualizado correctamente',
            'servicio' => $servicio
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/servicios/{id}
     * Elimina un servicio y todas sus imágenes asociadas
     */
    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);

        // 1) Borrar archivos físicos y registros en images + pivote
        foreach ($servicio->images as $img) {
            Storage::disk('public')->delete($img->url);
            $img->delete(); // Esto cascada borrará también de imageables
        }

        // 2) Eliminar el propio servicio
        $servicio->delete();

        return response()->json([
            'message' => 'Servicio eliminado correctamente'
        ], Response::HTTP_OK);
    }
}
