<?php

namespace App\Http\Controllers\Municipalidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MunicipalidadDescripcion;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class MunicipalidadDescripcionController extends Controller
{
    /**
     * Mostrar el único registro de la municipalidad.
     */
    public function index()
    {
        $municipalidad = MunicipalidadDescripcion::with('images')->first();
        return view('Municipalidad.index', compact('municipalidad'));
    }

    /**
     * Crear el único registro (solo si no existe).
     */
    public function store(Request $request)
    {
        if (MunicipalidadDescripcion::count() > 0) {
            return redirect()->route('municipalidad.index')->with('error', 'Ya existe un registro de la municipalidad.');
        }

        $data = $request->validate([
            'direccion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'ruc' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20',
            'nombre_alcalde' => 'nullable|string|max:100',
            'facebook_url' => 'nullable|url|max:255',
            'anio_gestion' => 'nullable|string|max:10',
        ]);

        MunicipalidadDescripcion::create($data);

        return redirect()->route('municipalidad.index')->with('success', 'Municipalidad registrada correctamente.');
    }

    /**
     * Actualizar un campo específico (tipo edición rápida).
     */
    public function update(Request $request, $id)
    {
        $municipalidad = MunicipalidadDescripcion::findOrFail($id);

        // Solo se actualiza el campo enviado en el request
        $campos = $request->except(['_token', '_method']);
        $municipalidad->update($campos);

        return redirect()->route('municipalidad.index')->with('success', 'Dato actualizado.');
    }

    /**
     * Subir o reemplazar una imagen polimórfica (logo, portada, perfil).
     */
    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'tipo' => 'required|in:logo,portada,perfil,galeria',
        ]);

        $municipalidad = MunicipalidadDescripcion::findOrFail($id);

        // Guardar nueva imagen sin eliminar las anteriores
        $path = $request->file('image')->store('municipalidad', 'public');

        $municipalidad->images()->create([
            'url' => $path,
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('municipalidad.index')->with('success', 'Imagen agregada correctamente.');
    }


      /**
     * Mostrar la galería completa de imágenes de la municipalidad.
     */
    public function galeria()
    {
        $municipalidad = MunicipalidadDescripcion::with('images')->first();
        return view('Municipalidad.galeria', compact('municipalidad'));
    }


    /**
     * Eliminar una imagen por ID.
     */
    public function destroyImagen($id)
    {
        $imagen = Image::findOrFail($id);

        // Eliminar archivo del storage
        if (Storage::disk('public')->exists($imagen->url)) {
            Storage::disk('public')->delete($imagen->url);
        }

        // Eliminar el registro de la base de datos
        $imagen->delete();

        return redirect()->back()->with('success', 'Imagen eliminada correctamente.');
    }


}
