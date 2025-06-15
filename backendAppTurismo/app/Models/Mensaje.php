<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';
    protected $primaryKey = 'mensajes_id';
    public $timestamps = false;

    protected $fillable = [
        'conversaciones_id',
        'emisor',
        'contenido',
        'imagen_url',
        'leido',
        'enviado_en'
    ];

    // Relaciones
    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class, 'conversaciones_id', 'conversaciones_id');
    }
}
