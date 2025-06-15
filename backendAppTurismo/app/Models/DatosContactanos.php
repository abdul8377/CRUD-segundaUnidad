<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosContactanos extends Model
{
    protected $table = 'datos_contactanos';
    protected $primaryKey = 'datos_contactanos_id';
    public $timestamps = false;

    protected $fillable = [
        'telefono',
        'correo_contacto',
        'horario_atencion',
        'dias_laborales',
        'link_whatsapp'
    ];
}
