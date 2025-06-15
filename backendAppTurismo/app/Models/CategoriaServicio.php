<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class CategoriaServicio extends Model
{
    use HasFactory;

    protected $table = 'categorias_servicios';
    protected $primaryKey = 'categorias_servicios_id';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'icono',
    ];

    protected $appends = ['imagen_url', 'icono_url'];
    protected $hidden  = ['imagen', 'icono'];

    // Relación polimórfica correcta
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(
            Images::class,       // Modelo destino
            'imageables',        // Nombre de la tabla pivote
            'imageable_id',      // FK en pivote que apunta a categorias_servicios.categorias_servicios_id
            'images_id'          // FK en pivote que apunta a images.id
        )
        ->wherePivot('imageable_type', self::class)  // Sólo las filas cuyo imageable_type coincida
        ->withTimestamps();                          // Para usar created_at / updated_at en pivote
    }


    public function getImagenUrlAttribute(): ?string
    {
        $imagenes = $this->images()->get();
        $imagen = $imagenes->first(function($img) {
            // elegimos la imagen que NO sea el icono
            return stripos($img->titulo, 'Icono') === false;
        });

        if (! $imagen) {
            return null;
        }

        $url = $imagen->url;

        // si ya es URL absoluta, la devolvemos tal cual
        if (Str::startsWith($url, ['http://','https://'])) {
            return $url;
        }

        // si es ruta relativa, construimos con asset()
        return asset("storage/{$url}");
    }

    public function getIconoUrlAttribute(): ?string
    {
        $imagenes = $this->images()->get();
        $icono = $imagenes->first(function($img) {
            // elegimos la imagen cuyo título sí contenga “Icono”
            return stripos($img->titulo, 'Icono') !== false;
        });

        if (! $icono) {
            return null;
        }

        $url = $icono->url;

        if (Str::startsWith($url, ['http://','https://'])) {
            return $url;
        }

        return asset("storage/{$url}");
    }


    // Relación con servicios
    // public function servicios()
    // {
    //     return $this->hasMany(Servicio::class, 'categorias_servicios_id');
    // }
}
