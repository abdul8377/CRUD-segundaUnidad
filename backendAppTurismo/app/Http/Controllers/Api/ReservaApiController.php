<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaApiController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'detalles'])->get();
        return response()->json($reservas);
    }

    public function show($id)
{
    $reserva = Reserva::with(['usuario', 'detalles'])->findOrFail($id);

    // Calculamos el total sumando el campo 'total' de cada detalle
    $total = $reserva->detalles->sum('total');

    // Podemos agregar el total como un campo adicional
    return response()->json([
        'reserva' => $reserva,
        'total' => $total
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => 'required|exists:users,id',
            'fecha_reserva' => 'required|date',
            'estado' => 'required|in:pendiente,confirmada,cancelada,consumida,no_asistió',
            'notas' => 'nullable|string',
        ]);

        $reserva = Reserva::create($validated);

        return response()->json(['message' => 'Reserva creada exitosamente', 'reserva' => $reserva], 201);
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $validated = $request->validate([
            'users_id' => 'sometimes|exists:users,id',
            'fecha_reserva' => 'sometimes|date',
            'estado' => 'sometimes|in:pendiente,confirmada,cancelada,consumida,no_asistió',
            'notas' => 'nullable|string',
        ]);

        $reserva->update($validated);

        return response()->json(['message' => 'Reserva actualizada', 'reserva' => $reserva]);
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return response()->json(['message' => 'Reserva eliminada']);
    }
}
