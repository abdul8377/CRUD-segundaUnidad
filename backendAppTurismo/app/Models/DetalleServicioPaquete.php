<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleServicioPaquete extends Model
{
    protected $table = 'detalle_servicio_paquete';
    protected $primaryKey = 'detalle_servicio_paquete_id';
    public $timestamps = false;

    protected $fillable = [
        'paquetes_id',
        'servicios_id'
    ];

    public function paquete()
    {
        return $this->belongsTo(Paquete::class, 'paquetes_id', 'paquetes_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicios_id', 'servicios_id');
    }
}
