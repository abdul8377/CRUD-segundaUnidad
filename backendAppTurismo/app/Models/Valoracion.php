<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';
    protected $primaryKey = 'valoraciones_id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'emprendimientos_id',
        'puntuacion',
        'comentario'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }
}
