<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioEmprendimiento extends Model
{
    protected $table = 'horarios_emprendimiento';
    protected $primaryKey = 'horarios_emprendimiento_id';
    public $timestamps = false;

    protected $fillable = [
        'emprendimientos_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin'
    ];

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimientos_id', 'emprendimientos_id');
    }
}
