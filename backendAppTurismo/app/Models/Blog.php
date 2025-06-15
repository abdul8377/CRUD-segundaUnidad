<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'blogs_id';
    public $timestamps = true; // porque usas created_at y updated_at

    protected $fillable = [
        'emprendimientos_id',
        'titulo',
        'contenido',
        'imagen_destacada',
        'fecha_publicacion',
        'estado'
    ];

    // Relaciones
    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }
}
