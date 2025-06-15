<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerminosCondiciones extends Model
{
    protected $table = 'terminos_condiciones';
    protected $primaryKey = 'terminos_condiciones_id';
    public $timestamps = true;

    protected $fillable = [
        'titulo',
        'contenido',
        'version',
        'vigente'
    ];
}
