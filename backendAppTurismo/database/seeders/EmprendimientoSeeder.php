<?php

namespace Database\Seeders;

use App\Models\Emprendimiento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use App\Models\Images;

class EmprendimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Definimos varios ejemplos de emprendimientos con sus datos y rutas de imagenes
        $fixtures = [

            [
                'nombre'          => 'Hostal Lago Azul',
                'descripcion'     => 'Hospedaje tranquilo junto al lago Titicaca',
                'tipo_negocio_id' => 4,
                'direccion'       => 'Av. Costanera 123, Puno',
                'telefono'        => '912345678',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientohabitaciones.jpeg'),
                    database_path('seeders/fixtures/emprendimientos/emprendimientohabitaciones.jpeg'),
                ],
            ],
            [
                'nombre'          => 'Hostal el Amanecer',
                'descripcion'     => 'Alojamiento con vista al amanecer andino.',
                'tipo_negocio_id' => 4,
                'direccion'       => 'Calle Los Andes 45, Puno',
                'telefono'        => '923456789',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientohotel2.jpg'),
                    database_path('seeders/fixtures/emprendimientos/emprendimientohabitaciones2.jpg'),
                ],
            ],
            // 🍽️ Gastronomía (tipo_negocio_id = 2)
            [
                'nombre'          => 'Restaurante Andino',
                'descripcion'     => 'Delicias de la sierra peruana.',
                'tipo_negocio_id' => 2,
                'direccion'       => 'Jr. Comercio 101, Puno',
                'telefono'        => '987654321',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientogastronomia.jpeg'),
                    database_path('seeders/fixtures/emprendimientos/emprendimientogastronomia2.jpeg'),
                ],
            ],
            [
                'nombre'          => 'Sazón Altiplánica',
                'descripcion'     => 'Gastronomía típica con productos locales.',
                'tipo_negocio_id' => 2,
                'direccion'       => 'Av. El Sol 200, Puno',
                'telefono'        => '923987654',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientogastronomia3.jpg'),
                    database_path('seeders/fixtures/emprendimientos/emprendimientogastronomia4.webp'),
                ],
            ],
            // 🛍️ productos (tipo_negocio_id = 2)
            [
                'nombre'          => 'Textiles Puno',
                'descripcion'     => 'Artesanías en telares tradicionales.',
                'tipo_negocio_id' => 1,
                'direccion'       => 'Calle Artesanos 12, Puno',
                'telefono'        => '987654322',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientosproductos1.jpeg'),
                ],
            ],
            [
                'nombre'          => 'Cerámica Titicaca',
                'descripcion'     => 'Cerámica tradicional de la región.',
                'tipo_negocio_id' => 1,
                'direccion'       => 'Av. Lago 300, Puno',
                'telefono'        => '923456788',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientosproductos.jpg'),
                ],
            ],
            // 🚴 Experiencias (tipo_negocio_id = 3)
            [
                'nombre'          => 'Titicaca Tours',
                'descripcion'     => 'Tours de aventura y cultura alrededor del Lago Titicaca.',
                'tipo_negocio_id' => 3,
                'direccion'       => 'Av. Principal 100, Puno',
                'telefono'        => '987654323',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientoexperiencias1.jpeg'),
                ],
            ],

            [
                'nombre'          => 'Aventura Andina',
                'descripcion'     => 'Experiencias de montaña y cultura local.',
                'tipo_negocio_id' => 3,
                'direccion'       => 'Jr. Libertad 200, Puno',
                'telefono'        => '923456787',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientosexperiencias.jpg'),
                ],
            ],
            [
                'nombre'          => 'Guías Andinos',
                'descripcion'     => 'Expertos locales que acompañan a los turistas en caminatas y excursiones culturales por la región.',
                'tipo_negocio_id' => 5,
                'direccion'       => 'Av. Los Andes 55, Puno',
                'telefono'        => '987654325',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientosguias.jpg'),
                ],
            ],

            [
                'nombre'          => 'Explora Titicaca',
                'descripcion'     => 'Guías certificados para explorar la biodiversidad y las tradiciones del Lago Titicaca.',
                'tipo_negocio_id' => 5,
                'direccion'       => 'Jr. Lima 300, Puno',
                'telefono'        => '923456785',
                'estado'          => 'activo',
                'fecha_registro'  => now(),
                'imagenes'        => [
                    database_path('seeders/fixtures/emprendimientos/emprendimientosguias1.webp'),
                ],
            ],


            // Agrega tantos ejemplos como quieras...
        ];

        foreach ($fixtures as $f) {
            // 1) Crear el emprendimiento (sin imágenes)
            $empr = Emprendimiento::create([
                'nombre'          => $f['nombre'],
                'descripcion'     => $f['descripcion'],
                'tipo_negocio_id' => $f['tipo_negocio_id'],
                'direccion'       => $f['direccion'],
                'telefono'        => $f['telefono'],
                'estado'          => $f['estado'],
                'fecha_registro'  => now(),
                // No incluimos 'imagen' aquí, porque usaremos la tabla polymórfica
            ]);

            // 2) Para cada ruta de imagen en el array, guardamos el archivo y creamos los registros correspondientes
            foreach ($f['imagenes'] as $rutaLocal) {
                // 2.1) Copiar el archivo desde database/seeders/fixtures/... a storage/app/public/emprendimientos/{id}/nombre.jpg
                $publicPath = Storage::disk('public')->putFile(
                    "emprendimientos/{$empr->getKey()}",
                    new File($rutaLocal)
                );

                // 2.2) Crear un registro en la tabla 'images'
                $img = Images::create([
                    'url'    => $publicPath,
                    'titulo' => $empr->nombre . ' (Imagen)',
                ]);

                // 2.3) Insertar la relación polimórfica en 'imageables'
                DB::table('imageables')->insert([
                    'images_id'      => $img->id,
                    'imageable_id'   => $empr->getKey(),
                    'imageable_type' => Emprendimiento::class,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }
}
