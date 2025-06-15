<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'user_code_plain',  // Código original sin cifrar
        'user',             // Código cifrado (hash)
        'email',
        'password',
        'country',
        'zip_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'user',  // Ocultamos el hash del código para no exponerlo
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // No se aplica cast para 'user' porque es hash bcrypt con sal
    ];

    /**
     * Genera un código numérico único de 9 dígitos.
     *
     * @return string
     */
    public static function generateUniqueUserCode(): string
    {
        do {
            $code = (string) mt_rand(100000000, 999999999);
        } while (self::where('user_code_plain', $code)->exists());

        return $code;
    }

    /**
     * Asigna automáticamente el código y su hash al usuario.
     *
     * Debe llamarse antes de guardar el usuario.
     */
    public function setUserCode(): void
    {
        $code = self::generateUniqueUserCode();
        $this->user_code_plain = $code;
        $this->user = Hash::make($code);
    }

    /**
     * Verifica que un código dado coincida con el código hash almacenado.
     *
     * @param string $inputCode
     * @return bool
     */
    public function verifyUserCode(string $inputCode): bool
    {
        return Hash::check($inputCode, $this->user);
    }

    /**
     * Obtiene las iniciales del usuario.
     *
     * @return string
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Relación uno a uno con PerfilEmprendedor.
     */
    public function perfilEmprendedor()
    {
        return $this->hasOne(PerfilEmprendedor::class, 'users_id', 'id');
    }

    /**
     * Relación uno a uno con PerfilTurista.
     */
    public function perfilTurista()
    {
        return $this->hasOne(PerfilTurista::class, 'users_id', 'id');
    }

    /**
     * Relación muchos a muchos con Emprendimiento a través de 'emprendimiento_usuarios'.
     */
    public function emprendimientos()
    {
        return $this->belongsToMany(
            Emprendimiento::class,
            'emprendimiento_usuarios',
            'users_id',
            'emprendimientos_id'
        )
        ->withPivot('rol_emprendimiento', 'fecha_asignacion')
        ->withTimestamps();
    }

    /**
     * Relación uno a muchos con EmprendimientoUsuario.
     */
    public function emprendimientoUsuarios()
    {
        return $this->hasMany(EmprendimientoUsuario::class, 'users_id');
    }
}
