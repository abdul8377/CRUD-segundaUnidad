<?php

namespace App\Http\Controllers\Municipalidad;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Mostrar sliders activos y todos disponibles.
     */
    public function index()
    {
        $sliders = Slider::with('portada')->orderBy('created_at', 'desc')->get();
        $slidersEnOrden = [
            1 => $sliders->firstWhere('orden', 1),
            2 => $sliders->firstWhere('orden', 2),
            3 => $sliders->firstWhere('orden', 3),
        ];

        return view('Municipalidad.Slider.index', compact('slidersEnOrden'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('Municipalidad.Slider.create');
    }

    /**
     * Almacenar un nuevo slider.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
            'imagen' => 'required|image|max:2048',
            'orden' => 'required|in:1,2,3',
        ]);

        $slider = Slider::create($request->only(['titulo', 'descripcion', 'orden']));

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('sliders', 'public');

            $slider->images()->create([
                'url' => 'storage/' . $path,
                'tipo' => 'portada',
            ]);
        }

        return redirect()->route('slider.index')->with('success', 'Slider creado correctamente.');
    }

    /**
     * Editar un slider específico.
     */
    public function edit(Slider $slider)
    {
        return view('Municipalidad.Slider.edit', compact('slider'));
    }

    /**
     * Actualizar un slider.
     */
   public function update(Request $request, Slider $slider)
{
        $request->validate([
        'titulo' => 'nullable|string|max:150',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:5120', // en KB
    ]);

    // Actualiza título y descripción
    $slider->update($request->only(['titulo', 'descripcion']));

    // Si viene una nueva imagen
    if ($request->hasFile('imagen')) {
        // Guardar nueva imagen en 'sliders/' dentro de 'public'
        $path = $request->file('imagen')->store('sliders', 'public');

        // Asocia la nueva imagen sin eliminar las anteriores
        $slider->images()->create([
            'url'  => $path,
            'tipo' => 'portada',
        ]);
    }

    return redirect()->route('slider.index')->with('success', 'Slider actualizado correctamente.');
}



    /**
     * Eliminar un slider.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->portada) {
            Storage::disk('public')->delete(str_replace('storage/', '', $slider->portada->url));
            $slider->portada->delete();
        }

        $slider->delete();

        return redirect()->route('slider.index')->with('success', 'Slider eliminado correctamente.');
    }

    /**
     * Mostrar vista para cambiar el slider de una posición específica.
     */
    public function editarOrden($orden)
    {
        $sliders = Slider::with('portada')
            ->where('orden', $orden)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('Municipalidad.Slider.editar_orden', compact('sliders', 'orden'));
    }

    /**
     * Activar un slider reutilizado en una posición específica.
     */
    public function activar(Request $request, Slider $slider)
    {
        $request->validate([
            'orden' => 'required|in:1,2,3',
        ]);

        $orden = $request->orden;

        $sliderExistente = Slider::where('orden', $orden)->first();
        if ($sliderExistente && $sliderExistente->id !== $slider->id) {
            $sliderExistente->update(['orden' => null]);
        }

        $slider->update(['orden' => $orden]);

        return redirect()->route('slider.index')->with('success', 'Slider activado en orden ' . $orden . '.');
    }
}
