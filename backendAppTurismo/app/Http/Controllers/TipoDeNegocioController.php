<?php

namespace App\Http\Controllers;

use App\Models\TipoDeNegocio;
use Illuminate\Http\Request;

class TipoDeNegocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoDeNegocio::withCount('emprendimientos')->get();
        return view('TipoNegocio.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('TipoNegocio.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        TipoDeNegocio::create($validated);

        return redirect()->route('tipos-de-negocio.index')
                        ->with('success', 'Tipo de negocio creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TipoDeNegocio $tipoDeNegocio)
    {
        // Cargar los emprendimientos vinculados
        $tipoDeNegocio->load('emprendimientos');

        return view('TipoNegocio.show', compact('tipoDeNegocio'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoDeNegocio $tipoDeNegocio)
    {
        return view('TipoNegocio.edit', compact('tipoDeNegocio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoDeNegocio $tipoDeNegocio)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipoDeNegocio->update($validated);

        return redirect()->route('tipos-de-negocio.index')
                        ->with('success', 'Tipo de negocio actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
