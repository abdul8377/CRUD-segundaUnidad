<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ZonaTuristica extends Model
{
    protected $table = 'zonas_turisticas';
    protected $primaryKey = 'zonas_turisticas_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'ubicacion',
        'estado',
    ];


    protected $appends = ['imagen_url'];


    public function images(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Models\Images::class, // Modelo destino
            'imageables',              // Tabla pivote
            'imageable_id',            // FK pivote -> zonas_turisticas.zonas_turisticas_id
            'images_id'                // FK pivote -> images.id
        )
        ->wherePivot('imageable_type', self::class)
        ->withTimestamps();
    }

    /**
     * 2) Accesor que construye la URL pública de la primera imagen
     */
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
}
