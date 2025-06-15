<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuentos';
    protected $primaryKey = 'descuentos_id';
    public $timestamps = false;

    protected $fillable = [
        'productos_id',
        'categorias_id',
        'servicios_id',
        'emprendimientos_id',
        'nombre_descuento',
        'descripcion',
        'porcentaje',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id', 'productos_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicios_id', 'servicios_id');
    }

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }


}
