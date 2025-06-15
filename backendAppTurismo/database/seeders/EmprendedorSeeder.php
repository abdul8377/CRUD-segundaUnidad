<?php

namespace Database\Seeders;

use App\Models\CategoriaServicio;
use App\Models\CategoriaProducto;
use App\Models\Emprendimiento;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\User;
use App\Models\PerfilEmprendedor;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class EmprendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user1 = User::create([
            'name' => 'Juan',
            'last_name' => 'Perez',
            'user' => bcrypt('user123'),
            'user_code_plain' => 'user123',
            'email' => 'juan.perez1@example.com',
            'password' => bcrypt('password123'),
            'country' => 'Perú',
            'zip_code' => '12345',
        ]);

        $role = Role::findOrCreate('Emprendedor');
        $user1->assignRole($role);


        $perfil1 = PerfilEmprendedor::create([
            'users_id' => $user1->id,
            'dni' => '12345678',
            'telefono_contacto' => '987654321',
            'experiencia' => 'Emprendedor en el sector de gastronomía andina.',
            'estado_validacion' => 'pendiente',
            'descripcion_emprendimiento' => 'Restaurante dedicado a la comida típica andina, como la torreja de quinua y t’himpo de pejerrey.',
            'gmail_contacto' => 'juan.perez1@gmail.com',
            'gmail_confirmado' => true,
            'codigo' => 'EMPR001',
        ]);

        $user2 = User::create([
            'name' => 'Maria',
            'last_name' => 'Lopez',
            'user' => bcrypt('user456'),
            'user_code_plain' => 'user456',
            'email' => 'maria.lopez@example.com',
            'password' => bcrypt('password456'),
            'country' => 'Perú',
            'zip_code' => '12346',
        ]);

        $user2->assignRole($role);


        $perfil2 = PerfilEmprendedor::create([
            'users_id' => $user2->id,
            'dni' => '87654321',
            'telefono_contacto' => '987654322',
            'experiencia' => 'Emprendedora en el sector de productos artesanales.',
            'estado_validacion' => 'pendiente',
            'descripcion_emprendimiento' => 'Tienda dedicada a la venta de productos textiles y cerámicos, hechos a mano por comunidades locales.',
            'gmail_contacto' => 'maria.lopez@gmail.com',
            'gmail_confirmado' => true,
            'codigo' => 'EMPR002',
        ]);

        $user3 = User::create([
            'name' => 'Carlos',
            'last_name' => 'Sánchez',
            'user' => bcrypt('user789'),
            'user_code_plain' => 'user789',
            'email' => 'carlos.sanchez@example.com',
            'password' => bcrypt('password789'),
            'country' => 'Perú',
            'zip_code' => '12347',
        ]);

        $user3->assignRole($role);


        $perfil3 = PerfilEmprendedor::create([
            'users_id' => $user3->id,
            'dni' => '11223344',
            'telefono_contacto' => '987654323',
            'experiencia' => 'Emprendedor en el sector de servicios turísticos.',
            'estado_validacion' => 'pendiente',
            'descripcion_emprendimiento' => 'Agencia de viajes especializada en tours a comunidades andinas.',
            'gmail_contacto' => 'carlos.sanchez@gmail.com',
            'gmail_confirmado' => true,
            'codigo' => 'EMPR003',
        ]);

    }
}
