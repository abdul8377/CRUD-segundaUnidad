<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apelacion extends Model
{
    protected $table = 'apelaciones';
    protected $primaryKey = 'apelaciones_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'motivo',
        'evidencia',
        'estado'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
