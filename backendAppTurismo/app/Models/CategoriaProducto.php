<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{


    use HasFactory;

    protected $table = 'categorias_productos';
    protected $primaryKey = 'categorias_productos_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación con los productos
    public function productos()
    {
        // Asegúrate de que los campos de clave foránea y primaria estén correctamente asignados
        return $this->hasMany(Producto::class, 'categorias_productos_id', 'categorias_productos_id');
    }
}
