<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = 'monedas';
    protected $primaryKey = 'codigo';
    public $incrementing = false; // porque es VARCHAR(3)
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'simbolo'
    ];

    public function tiposCambio()
    {
        return $this->hasMany(TipoCambio::class, 'codigo_moneda', 'codigo');
    }
}
