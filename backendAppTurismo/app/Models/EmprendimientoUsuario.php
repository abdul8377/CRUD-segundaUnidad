<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmprendimientoUsuario extends Model
{
    protected $table = 'emprendimiento_usuarios';
    protected $primaryKey = 'emprendimiento_usuarios_id';
    public $timestamps = false;

    protected $fillable = [
        'emprendimientos_id',
        'users_id',
        'rol_emprendimiento',
        'fecha_asignacion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }
}
