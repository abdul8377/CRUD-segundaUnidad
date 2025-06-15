<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'productos_id';
    public $timestamps = false;

    protected $fillable = [
        'emprendimientos_id',
        'categorias_productos_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'capacidad_total',
        'estado',
        'imagen',
    ];
    protected $appends = ['imagen_url'];

    // Relación polimórfica con iamgenes
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
        $img = $this->images()->get()->first();
        if (! $img) {
            return null;
        }
        $url = $img->url;
        if (Str::startsWith($url, ['http://','https://'])) {
            return $url;
        }
        return URL::to("storage/{$url}");

    }


    public function categoria()
    {
        // Asegúrate de que los campos de clave foránea y primaria estén correctamente asignados
        return $this->belongsTo(CategoriaProducto::class, 'categorias_productos_id', 'categorias_productos_id');
    }
}
