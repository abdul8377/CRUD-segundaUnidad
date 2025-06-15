<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imageable extends Model
{
    protected $fillable = ['images_id', 'imageable_id', 'imageable_type'];

    public function imagen()
    {
        return $this->belongsTo(Images::class);
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
