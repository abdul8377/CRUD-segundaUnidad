<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(){
        $role=Role::create(['name'=>'Administrador']);
        $role->permissions()->attach([1,2,3,4,5,8]);

        $role=Role::create(['name'=>"Usuario"]);
        $role->permissions()->attach([6]);

        $role=Role::create(['name'=>"Emprendedor"]);
        $role->permissions()->attach([7]);
    }

}
