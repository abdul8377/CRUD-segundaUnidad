<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $table = 'conversaciones';
    protected $primaryKey = 'conversaciones_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'emprendimientos_id'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'conversaciones_id', 'conversaciones_id');
    }
}
