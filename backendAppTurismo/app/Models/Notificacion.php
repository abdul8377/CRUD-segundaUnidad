<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'notificaciones_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'tipo',
        'contenido',
        'leido',
        'creado_en'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
