<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialVisita extends Model
{
    protected $table = 'historial_visitas';
    protected $primaryKey = 'historial_visitas_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'productos_id',
        'servicios_id',
        'fecha_visita'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id', 'productos_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicios_id', 'servicios_id');
    }
}
