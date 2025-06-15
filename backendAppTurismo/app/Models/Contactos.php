<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    protected $table = 'contactos';
    protected $primaryKey = 'contactos_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'asunto',
        'mensaje'
    ];
}
