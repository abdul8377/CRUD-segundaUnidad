<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'roles_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'guard_name'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'roles_id', 'roles_id');
    }
}
