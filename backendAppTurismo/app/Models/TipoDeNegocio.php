<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeNegocio extends Model
{
    use HasFactory;

    // Nombre de la tabla si no sigue convención
    protected $table = 'tipos_de_negocio';

    // Clave primaria (opcional si se usa 'id')
    protected $primaryKey = 'id';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación con emprendimientos
    public function emprendimientos()
    {
        return $this->hasMany(Emprendimiento::class, 'tipo_negocio_id');
    }
}
