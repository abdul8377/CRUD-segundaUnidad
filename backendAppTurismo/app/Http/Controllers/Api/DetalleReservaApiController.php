<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleReserva;
use Illuminate\Http\Request;

class DetalleReservaApiController extends Controller
{
    public function index()
    {
        $detalles = DetalleReserva::with(['reserva', 'producto', 'servicio'])->get();
        return response()->json($detalles);
    }

    public function show($id)
    {
        $detalle = DetalleReserva::with(['reserva', 'producto', 'servicio'])->findOrFail($id);
        return response()->json($detalle);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reserva_id' => 'required|exists:reservas,reservas_id',
            'productos_id' => 'nullable|exists:productos,productos_id',
            'servicios_id' => 'nullable|exists:servicios,servicios_id',
            'cantidad' => 'required|integer|min:1',
            'hora_reserva' => 'required|date_format:H:i:s',
            'precio_unitario' => 'required|numeric|min:0',
            'descuento_aplicado' => 'nullable|numeric|min:0|max:100',
        ]);

        $detalle = DetalleReserva::create($validated);

        return response()->json(['message' => 'Detalle de reserva creado exitosamente', 'detalle' => $detalle], 201);
    }

    public function update(Request $request, $id)
    {
        $detalle = DetalleReserva::findOrFail($id);

        $validated = $request->validate([
            'reserva_id' => 'sometimes|exists:reservas,reservas_id',
            'productos_id' => 'nullable|exists:productos,productos_id',
            'servicios_id' => 'nullable|exists:servicios,servicios_id',
            'cantidad' => 'sometimes|integer|min:1',
            'hora_reserva' => 'sometimes|date_format:H:i:s',
            'precio_unitario' => 'sometimes|numeric|min:0',
            'descuento_aplicado' => 'nullable|numeric|min:0|max:100',
        ]);

        $detalle->update($validated);

        return response()->json(['message' => 'Detalle de reserva actualizado', 'detalle' => $detalle]);
    }

    public function destroy($id)
    {
        $detalle = DetalleReserva::findOrFail($id);
        $detalle->delete();

        return response()->json(['message' => 'Detalle de reserva eliminado']);
    }
}
