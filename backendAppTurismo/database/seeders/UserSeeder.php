<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Franck Coaquira',
            'last_name' => 'Coaquira',
            'user' => 'franckcoaq',
            'email' => 'franck@gmail.com',
            'password' => bcrypt('12345678'),
            'country' => 'PE', // Código ISO del país, por ejemplo PE para Perú
            'zip_code' => '051',
        ]);
        $user->assignRole('Administrador');

        $user = User::create([
            'name' => 'Emprendedor1',
            'last_name' => 'Apellido',
            'user' => 'emprende01',
            'email' => 'emprendedor@gmail.com',
            'password' => bcrypt('12345678'),
            'country' => 'PE',
            'zip_code' => '052',
        ]);
        $user->assignRole('Emprendedor');

        $user = User::create([
            'name' => 'Usuario',
            'last_name' => 'Apellido',
            'user' => 'Usuario',
            'email' => 'Usuario@gmail.com',
            'password' => bcrypt('12345678'),
            'country' => 'PE',
            'zip_code' => '052',
        ]);
        $user->assignRole('Usuario');
    }
}
