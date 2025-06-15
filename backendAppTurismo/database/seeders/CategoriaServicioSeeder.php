<?php

namespace Database\Seeders;

use App\Models\CategoriaServicio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Images;
use Illuminate\Http\File;
class CategoriaServicioSeeder extends Seeder
{
    public function run()
    {

        $fixtures = [

            [
                'nombre'    => 'Gastronomía',
                'descripcion' => 'Sabores del mundo',
                'imagen'    => database_path('seeders/fixtures/gastronomia.webp'),
                'icono'     => database_path('seeders/fixtures/gastronomia.png'),
            ],
            [
                'nombre'    => 'experiencias',
                'descripcion' => 'Experiencias culturales',
                'imagen'    => database_path('seeders/fixtures/experiencias.jpg'),
                'icono'     => database_path('seeders/fixtures/experiencias.png'),
            ],
            [
                'nombre'    => 'alojamientoi',
                'descripcion' => 'mejores alojamientos',
                'imagen'    => database_path('seeders/fixtures/alojamiento.jpeg'),
                'icono'     => database_path('seeders/fixtures/alojamiento.png'),
            ],
            [
                'nombre'    => 'Guias',
                'descripcion' => 'mos mejores del mundo',
                'imagen'    => database_path('seeders/fixtures/guia.jpg'),
                'icono'     => database_path('seeders/fixtures/guia.png'),
            ],
            // … más categorías …
        ];

        foreach ($fixtures as $f) {

            $cat = CategoriaServicio::create([
                'nombre'      => $f['nombre'],
                'descripcion' => $f['descripcion'],
            ]);

            // 2) Almacena en storage/app/public/categorias:
            $imagenPath = Storage::disk('public')->putFile(
                'categorias',
                new File($f['imagen'])
            );

            // 3) Almacena en storage/app/public/icons:
            $iconoPath = Storage::disk('public')->putFile(
                'icons',
                new File($f['icono'])
            );

            // 4) Crea registros en images
            $img   = Images::create(['url' => $imagenPath, 'titulo' => $cat->nombre]);
            $ico   = Images::create(['url' => $iconoPath, 'titulo' => $cat->nombre . ' (Icono)']);

            // 5) Inserta en la tabla pivote
            DB::table('imageables')->insert([
                [
                    'images_id'      => $img->id,
                    'imageable_id'   => $cat->categorias_servicios_id,
                    'imageable_type' => CategoriaServicio::class,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ],
                [
                    'images_id'      => $ico->id,
                    'imageable_id'   => $cat->categorias_servicios_id,
                    'imageable_type' => CategoriaServicio::class,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ],
            ]);
        }
    }
}
