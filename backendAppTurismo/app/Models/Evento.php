<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'eventos_id';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'emprendimiento_id',
        'fecha_inicio',
        'fecha_fin',
        'hora',
        'capacidad_maxima',
        'lugar',
        'estado',
        'fecha_creacion'
    ];
}
