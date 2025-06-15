<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilEmprendedor extends Model
{

    use HasFactory;
    protected $table = 'perfil_emprendedor';
    protected $primaryKey = 'perfil_emprendedor_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'dni',
        'telefono_contacto',
        'experiencia',
        'estado_validacion',
        'descripcion_emprendimiento',
        'gmail_contacto',
        'gmail_confirmado',
        'codigo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
