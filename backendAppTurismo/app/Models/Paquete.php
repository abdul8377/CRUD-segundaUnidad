<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'paquetes';
    protected $primaryKey = 'paquetes_id';
    public $timestamps = false;

    protected $fillable = [
        'emprendimientos_id',
        'nombre',
        'descripcion',
        'precio_total',
        'estado'
    ];

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleServicioPaquete::class, 'paquetes_id', 'paquetes_id');
    }
}
