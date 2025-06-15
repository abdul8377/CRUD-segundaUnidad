<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilTurista extends Model
{
    protected $table = 'perfil_turista';
    protected $primaryKey = 'perfil_turista_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'nacionalidad',
        'edad',
        'intereses'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
