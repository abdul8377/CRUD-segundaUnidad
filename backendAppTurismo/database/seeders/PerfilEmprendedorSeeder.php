<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerfilEmprendedor;
use App\Models\User;
use Spatie\Permission\Models\Role;

class PerfilEmprendedorSeeder extends Seeder
{
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'Emprendedor']);

        // Crear 5 usuarios con datos completos y asignarles rol
        $users = User::factory(5)->create()->each(function ($user) use ($role) {
            $user->assignRole($role);
        });

        foreach ($users as $user) {
            PerfilEmprendedor::create([
                'users_id' => $user->id,
                'dni' => '12345678' . $user->id,
                'telefono_contacto' => '98765432' . $user->id,
                'experiencia' => 'Experiencia en emprendimiento número ' . $user->id,
                'estado_validacion' => 'pendiente',
                'descripcion_emprendimiento' => 'Descripción del emprendimiento para el usuario ' . $user->id,
                'gmail_contacto' => 'emprendedor' . $user->id . '@gmail.com',
                'gmail_confirmado' => true,
                'codigo' => 'EM' . $user->id . 'CODE',
            ]);
        }
    }
}
