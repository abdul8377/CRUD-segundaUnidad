<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use App\Models\ZonaTuristica;
use App\Models\Images;

class ZonasTuristicasSeeder extends Seeder
{
     public function run()
    {
        $fixtures = [
            [
                'nombre'      => 'ccotos',
                'descripcion' => 'Arena fina y aguas cristalinas',
                'ubicacion'   => 'Costa Azul',
                'estado'      => 'activo',
                'imagen'      => database_path('seeders/fixtures/zonas/ccotos.jpg'),
            ],
            [
                'nombre'      => 'chifron',
                'descripcion' => 'Senderos entre pinos',
                'ubicacion'   => 'Sierra Alta',
                'estado'      => 'activo',
                'imagen'      => database_path('seeders/fixtures/zonas/chifron.jpg'),
            ],

            [
                'nombre'      => 'escallani',
                'descripcion' => 'Senderos entre pinos',
                'ubicacion'   => 'Sierra Alta',
                'estado'      => 'activo',
                'imagen'      => database_path('seeders/fixtures/zonas/escallani.jpg'),

            ],
        ];

        foreach ($fixtures as $f) {
            // 1) crea la zona sin imagen
            $zona = ZonaTuristica::create([
                'nombre'      => $f['nombre'],
                'descripcion' => $f['descripcion'],
                'ubicacion'   => $f['ubicacion'],
                'estado'      => $f['estado'],
            ]);

            // 2) almacena la imagen en storage/app/public/zonas y guarda el path
            $imgPath = Storage::disk('public')->putFile(
                'zonas',
                new File($f['imagen'])
            );



            // 4) crea registros en images
            $img   = Images::create([ 'url' => $imgPath, 'titulo' => $zona->nombre ]);


            // 5) enlaza en la tabla pivote imageables
            DB::table('imageables')->insert([
                [
                    'images_id'      => $img->id,
                    'imageable_id'   => $zona->zonas_turisticas_id,
                    'imageable_type' => ZonaTuristica::class,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ],

            ]);
        }
    }
}
