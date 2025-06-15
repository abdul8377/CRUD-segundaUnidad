<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use App\Models\Producto;
use App\Models\Images;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $fixtures = [
            [
                'emprendimientos_id'       => 5,
                'categorias_productos_id'  => 1,
                'nombre'                   => 'Cubo Artesanal',
                'descripcion'              => 'Hecho a mano con madera local',
                'precio'                   => 25.50,
                'stock'                    => 100,
                'estado'                   => 'activo',
                'imagen'                   => database_path('seeders/fixtures/productos/producto1.jpeg'),
            ],
            [
                'emprendimientos_id'       => 6,
                'categorias_productos_id'  => 2,
                'nombre'                   => 'Pulsera de Alpaca',
                'descripcion'              => 'Diseño tradicional andino',
                'precio'                   => 12.00,
                'stock'                    => 200,
                'estado'                   => 'activo',
                'imagen'                   => database_path('seeders/fixtures/productos/producto2.webp'),
            ],
            [
                'emprendimientos_id'       => 5,
                'categorias_productos_id'  => 3,
                'nombre'                   => 'preubas 1',
                'descripcion'              => 'Diseño tradicional andino',
                'precio'                   => 120.00,
                'stock'                    => 20,
                'estado'                   => 'activo',
                'imagen'                   => database_path('seeders/fixtures/productos/producto3.jpg'),
            ],
            [
                'emprendimientos_id'       => 6,
                'categorias_productos_id'  => 4,
                'nombre'                   => 'Pulsera',
                'descripcion'              => 'Diseño tradicional andino',
                'precio'                   => 233.00,
                'stock'                    => 200,
                'estado'                   => 'activo',
                'imagen'                   => database_path('seeders/fixtures/productos/producto4.jpeg'),
            ],
            [
                'emprendimientos_id'       => 5,
                'categorias_productos_id'  => 5,
                'nombre'                   => 'Alpaca',
                'descripcion'              => 'Diseño tradicional andino',
                'precio'                   => 112.00,
                'stock'                    => 2200,
                'estado'                   => 'activo',
                'imagen'                   => database_path('seeders/fixtures/productos/producto5.jpeg'),
            ],
            [
                'emprendimientos_id'       => 6,
                'categorias_productos_id'  => 2,
                'nombre'                   => 'pruebas asd',
                'descripcion'              => 'Diseño tradicional andino',
                'precio'                   => 77.60,
                'stock'                    => 100,
                'estado'                   => 'activo',
                'imagen'                   => database_path('seeders/fixtures/productos/producto1.jpeg'),
            ],
            // añade más productos aquí…
        ];

        foreach ($fixtures as $f) {
            // 1) Crear el producto sin imagen
            $prod = Producto::create([
                'emprendimientos_id'      => $f['emprendimientos_id'],
                'categorias_productos_id' => $f['categorias_productos_id'],
                'nombre'                  => $f['nombre'],
                'descripcion'             => $f['descripcion'],
                'precio'                  => $f['precio'],
                'stock'                   => $f['stock'],
                'estado'                  => $f['estado'],
            ]);

            // 2) Almacenar el archivo en public/storage/productos
            $imgPath = Storage::disk('public')->putFile(
                'productos',
                new File($f['imagen'])
            );
            $prod->imagen = $imgPath;
            $prod->save();

            // 3) Guardar en la tabla images
            $img = Images::create([
                'url'    => $imgPath,
                'titulo' => $prod->nombre,
            ]);

            // 4) Enlazar en la tabla pivote imageables
            DB::table('imageables')->insert([
                'images_id'      => $img->id,
                'imageable_id'   => $prod->getKey(),
                'imageable_type' => Producto::class,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
