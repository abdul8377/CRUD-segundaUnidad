<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'detalle_reservas';
    protected $primaryKey = 'detalle_reservas_id';

    protected $fillable = [
        'reserva_id',
        'productos_id',
        'servicios_id',
        'cantidad',
        'hora_reserva'
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'reservas_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id', 'productos_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicios_id', 'servicios_id');
    }
    public function getTotalAttribute()
    {
        return $this->detalles->sum('total');
    }
}
