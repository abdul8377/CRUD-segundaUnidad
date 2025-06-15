<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmprendimientoUsuariosSeeder extends Seeder
{
    public function run()
    {


        $now = Carbon::now();

        $data = [

            [
                'emprendimientos_id' => 5,
                'users_id'           => 4,
                'rol_emprendimiento' => 'propietario',
                'fecha_asignacion'   => $now,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],


            [
                'emprendimientos_id' => 1,
                'users_id'           => 5,
                'rol_emprendimiento' => 'colaborador',
                'fecha_asignacion'   => $now,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],

        ];

        // 4) Inserta en bloque
        DB::table('emprendimiento_usuarios')->insert($data);
    }
}
