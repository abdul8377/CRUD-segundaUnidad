<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'sanciones';
    protected $primaryKey = 'sanciones_id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'motivo',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
