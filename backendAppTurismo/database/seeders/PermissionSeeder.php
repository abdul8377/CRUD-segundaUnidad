<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(){

        //D1 admin
        Permission::create([
            'name'=>'Listar Usuarios'
        ]);

        //D2 admin
        Permission::create([
            'name'=>'Crear Usuario'
        ]);

        //D3 admin
        Permission::create([
            'name'=>'Editar Usuario'
        ]);

        //D4 admin
        Permission::create([
            'name'=>'Editar Status'
        ]);

        //D5 admin
        Permission::create([
            'name'=>'Eliminar Uuario'
        ]);


        //usuarios Dashboard
        Permission::create([
            'name'=>'Ver Dashboard'
        ]);

         //usuarios Dashboard
         Permission::create([
            'name'=>'Ver Producto'
        ]);


        //Permiso de Rutas
        Permission::create([
            'name'=>'Ver Rutas'
        ]);

    }

}
