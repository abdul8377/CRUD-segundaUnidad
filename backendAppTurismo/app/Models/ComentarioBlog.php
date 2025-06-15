<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentarioBlog extends Model
{
    protected $table = 'comentarios_blog';
    protected $primaryKey = 'comentarios_blog_id';
    public $timestamps = false;


    protected $fillable = [
        'blogs_id',
        'users_id',
        'contenido'
    ];

    // Relaciones
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blogs_id', 'blogs_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
