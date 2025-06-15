<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudEmprendimiento extends Model
{

    use HasFactory;
    protected $table = 'solicitud_emprendimiento';

    protected $fillable = [
        'emprendimientos_id',
        'users_id',
        'estado',
        'rol_solicitado',
        'fecha_solicitud',
        'fecha_respuesta',
    ];

    // Relación con Emprendimiento
    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }

    // Relación con Usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
