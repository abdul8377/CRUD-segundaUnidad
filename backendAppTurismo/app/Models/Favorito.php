<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = 'favoritos';
    protected $primaryKey = 'favoritos_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'productos_id',
        'servicios_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id', 'productos_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicios_id', 'servicios_id');
    }
}
