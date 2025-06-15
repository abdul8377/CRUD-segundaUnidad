<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = 'tipo_cambio';
    protected $primaryKey = 'tipo_cambio_id';
    public $timestamps = false;

    protected $fillable = [
        'codigo_moneda',
        'tasa_cambio',
        'fecha'
    ];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'codigo_moneda', 'codigo');
    }
}
