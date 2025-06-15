<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    // Tabla y clave primaria personalizada
    protected $table = 'slider';
    protected $primaryKey = 'slider_id';

    // Campos asignables masivamente
    protected $fillable = [
        'titulo',
        'descripcion',
        'link',
        'orden',
        'estado',
    ];

    /**
     * Relación polimórfica: un slider puede tener muchas imágenes
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Relación con la imagen de portada (1 sola imagen destacada por slider)
     */
    public function portada()
    {
        return $this->morphOne(Image::class, 'imageable')->where('tipo', 'portada');
    }
}
