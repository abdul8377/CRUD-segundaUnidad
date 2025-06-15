<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienciaUsuario extends Model
{
    protected $table = 'experiencias_usuario';
    protected $primaryKey = 'experiencias_usuario_id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'titulo',
        'contenido',
        'imagen_destacada',
        'estado',
        'fecha_publicacion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
