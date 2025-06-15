<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MunicipalidadDescripcion extends Model
{
    protected $table = 'municipalidad_descripcion';
    protected $primaryKey = 'municipalidad_descripcion_id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'color_primario',
        'color_secundario',
        'mantenimiento',
        'direccion',
        'descripcion',
        'ruc',
        'correo',
        'telefono',
        'nombre_alcalde',
        'facebook_url',
        'anio_gestion',
    ];

    /**
     * Relación polimórfica con imágenes.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
