<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = ['url', 'titulo'];

    public function imageable()
    {
        return $this->morphTo();
    }

   public function getUrlAttribute(string $value): string
    {
        // $value es el contenido de la columna 'url' en la BD
        return asset('storage/' . $value);
    }
}
