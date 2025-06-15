<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';
    protected $primaryKey = 'servicios_id';
    public $timestamps = true;

    protected $fillable = [
        'emprendimientos_id',
        'nombre',
        'descripcion',
        'precio',
        'capacidad_maxima',
        'duracion_servicio',


    ];

    protected $appends = ['imagenes_url','imagen_url'];

    public function images(): MorphToMany
    {
        return $this->morphToMany(
            Images::class,
            'imageable',
            'imageables',
            'imageable_id',
            'images_id'
        )
            ->withTimestamps();
    }


    public function getImagenesUrlAttribute(): array
    {
        return $this->images
            ->map(function ($img) {
                $url = $img->url;
                if (Str::startsWith($url, ['http://', 'https://'])) {
                    return $url;
                }
                return URL::to('storage/' . $url);
            })
            ->toArray();
    }
    public function getImagenUrlAttribute(): ?string
    {
        $img = $this->images()->first();
        if (! $img) {
            return null;
        }
        $url = $img->url;
        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }
        return URL::to("storage/{$url}");
    }

    /**
     * Relación con el emprendimiento
     */
    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }
}
