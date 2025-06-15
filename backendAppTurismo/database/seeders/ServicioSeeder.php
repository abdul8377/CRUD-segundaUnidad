<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use App\Models\Servicio;
use App\Models\Images;

class ServicioSeeder extends Seeder
{
    public function run()
    {
        // -------------------------------------------------------------------
        // Ajusta estos fixtures según los IDs reales que tengas en tu BDD:
        // - 'emprendimientos_id' debe existir en la tabla `emprendimientos`
        // - 'categorias_servicios_id' debe existir en `categorias_servicios`
        // -------------------------------------------------------------------
        $fixtures = [

            // seeder para emprendimientos
            [
                'emprendimientos_id'      => 1,
                'nombre'                  => 'Habitación Simple',
                'descripcion'             => 'Cómoda habitación simple con vista al lago.',
                'precio'                  => 100.00,
                'capacidad_maxima'        => 2,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/emprendimientohabitaciones.jpeg'),
                    database_path('seeders/fixtures/servicios/emprendimientohabitaciones2.jpg'),
                ],
            ],
            [
                'emprendimientos_id'      => 1,
                'nombre'                  => 'Habitación Doble',
                'descripcion'             => 'Habitación doble ideal para parejas con baño privado.',
                'precio'                  => 180.00,
                'capacidad_maxima'        => 2,
                'duracion_servicio'       => '2 días',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciohabitacion1.jpg'),
                    database_path('seeders/fixtures/servicios/serviciohabitacion2.jpg'),
                ],
            ],
            [
                'emprendimientos_id'      => 1,
                'nombre'                  => 'Suite Familiar',
                'descripcion'             => 'Amplia suite para familias con todas las comodidades.',
                'precio'                  => 250.00,
                'capacidad_maxima'        => 4,
                'duracion_servicio'       => '3 días',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciohabitacion3.jpeg'),

                ],
            ],

            [
                'emprendimientos_id'      => 2,
                'nombre'                  => 'Habitación Simple',
                'descripcion'             => 'Confortable habitación con vista a las montañas.',
                'precio'                  => 90.00,
                'capacidad_maxima'        => 2,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/servicioshotel1.jpg'),
                    database_path('seeders/fixtures/servicios/servicioshotel2.jpg'),
                ],
            ],
            [
                'emprendimientos_id'      => 2,
                'nombre'                  => 'Habitación Doble',
                'descripcion'             => 'Cómoda habitación doble con baño privado y vistas increíbles.',
                'precio'                  => 170.00,
                'capacidad_maxima'        => 2,
                'duracion_servicio'       => '2 días',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/servicioshotel3.jpeg'),
                    database_path('seeders/fixtures/servicios/servicioshotel4.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 2,
                'nombre'                  => 'Suite Matrimonial',
                'descripcion'             => 'Suite matrimonial con terraza y servicio a la habitación.',
                'precio'                  => 220.00,
                'capacidad_maxima'        => 2,
                'duracion_servicio'       => '3 días',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/servicioshotel5.jpeg'),

                ],
            ],

            //seeders para emrpendimientos gastronomia

            [
                'emprendimientos_id'      => 3,
                'nombre'                  => 'Menú Andino Especial',
                'descripcion'             => 'Disfruta de los sabores autóctonos con este menú especial de la sierra peruana.',
                'precio'                  => 60.00,
                'capacidad_maxima'        => 50,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosgastronomia1.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosgastronomia8.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 3,
                'nombre'                  => 'Buffet Regional',
                'descripcion'             => 'Degustación de platos típicos en un buffet variado.',
                'precio'                  => 80.00,
                'capacidad_maxima'        => 80,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosgastronomia2.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosgastronomia7.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 3,
                'nombre'                  => 'Clase de Cocina Andina',
                'descripcion'             => 'Aprende a preparar platos típicos en esta experiencia culinaria única.',
                'precio'                  => 120.00,
                'capacidad_maxima'        => 20,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosgastronomia3.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosgastronomia6.jpg'),
                ],
            ],

            [
                'emprendimientos_id'      => 4,
                'nombre'                  => 'Desayuno Regional',
                'descripcion'             => 'Comienza tu día con un delicioso desayuno andino.',
                'precio'                  => 40.00,
                'capacidad_maxima'        => 30,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosgastronomia4.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosgastronomia8.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 4,
                'nombre'                  => 'Almuerzo Criollo',
                'descripcion'             => 'Disfruta de un almuerzo lleno de sabor y tradición.',
                'precio'                  => 70.00,
                'capacidad_maxima'        => 50,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosgastronomia5.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosgastronomia7.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 4,
                'nombre'                  => 'Cena Andina',
                'descripcion'             => 'Sabores de la noche andina en una experiencia culinaria inolvidable.',
                'precio'                  => 90.00,
                'capacidad_maxima'        => 40,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosgastronomia8.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosgastronomia7.jpeg'),
                ],
            ],

            // seeders para experiencias
            [
                'emprendimientos_id'      => 7,
                'nombre'                  => 'Tour Isla Flotante',
                'descripcion'             => 'Excursión a las islas flotantes de los Uros con guía local.',
                'precio'                  => 120.00,
                'capacidad_maxima'        => 20,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosexperiencias.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosexperiencias1.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 7,
                'nombre'                  => 'Caminata en Llachón',
                'descripcion'             => 'Caminata interpretativa en la comunidad de Llachón con paisajes inolvidables.',
                'precio'                  => 90.00,
                'capacidad_maxima'        => 15,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosexperiencias.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosexperiencias3.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 7,
                'nombre'                  => 'Full Day Lago Titicaca',
                'descripcion'             => 'Tour completo por el lago con experiencias culturales y gastronomía.',
                'precio'                  => 150.00,
                'capacidad_maxima'        => 25,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosexperiencias5.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosexperiencias6.webp'),
                ],
            ],
            [
                'emprendimientos_id'      => 8,
                'nombre'                  => 'Trekking Cordillera',
                'descripcion'             => 'Senderismo de alta montaña con paisajes únicos.',
                'precio'                  => 180.00,
                'capacidad_maxima'        => 12,
                'duracion_servicio'       => '2 días',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosexperiencias4.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosexperiencias5.jpg'),
                ],
            ],
            [
                'emprendimientos_id'      => 8,
                'nombre'                  => 'Experiencia Cultural',
                'descripcion'             => 'Vive la cultura local con actividades y talleres tradicionales.',
                'precio'                  => 100.00,
                'capacidad_maxima'        => 20,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosexperiencias6.webp'),
                    database_path('seeders/fixtures/servicios/serviciosexperiencias1.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 8,
                'nombre'                  => 'Tour de Aventura',
                'descripcion'             => 'Actividades extremas y paisajes inolvidables.',
                'precio'                  => 150.00,
                'capacidad_maxima'        => 15,
                'duracion_servicio'       => '2 días',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosexperiencias3.jpeg'),

                ],
            ],
            //seeders guias

            [
                'emprendimientos_id'      => 9,
                'nombre'                  => 'Tour a la Isla Amantaní',
                'descripcion'             => 'Acompañamiento especializado en la isla Amantaní con guías locales.',
                'precio'                  => 110.00,
                'capacidad_maxima'        => 15,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosguias.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosguias1.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 9,
                'nombre'                  => 'Senderismo Cultural',
                'descripcion'             => 'Senderismo a través de comunidades andinas con interpretación cultural.',
                'precio'                  => 90.00,
                'capacidad_maxima'        => 20,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosguias1.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosguias2.jpg'),
                ],
            ],
            [
                'emprendimientos_id'      => 9,
                'nombre'                  => 'Full Day Lago Titicaca',
                'descripcion'             => 'Tour completo por el lago con guías locales y experiencias culturales.',
                'precio'                  => 130.00,
                'capacidad_maxima'        => 25,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosguias2.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosguias3.jpg'),
                ],
            ],

            [
                'emprendimientos_id'      => 10,
                'nombre'                  => 'Tour a Uros y Taquile',
                'descripcion'             => 'Explora las islas Uros y Taquile con guías certificados.',
                'precio'                  => 120.00,
                'capacidad_maxima'        => 20,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosguias3.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosguias4.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 10,
                'nombre'                  => 'Tour Cultural Andino',
                'descripcion'             => 'Vive la cultura local a través de experiencias inolvidables.',
                'precio'                  => 100.00,
                'capacidad_maxima'        => 15,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosguias4.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosguias5.jpeg'),
                ],
            ],
            [
                'emprendimientos_id'      => 10,
                'nombre'                  => 'Full Day Lago Titicaca',
                'descripcion'             => 'Recorrido completo por el lago con guías expertos y actividades interactivas.',
                'precio'                  => 140.00,
                'capacidad_maxima'        => 25,
                'duracion_servicio'       => '1 día',
                'imagenes'                => [
                    database_path('seeders/fixtures/servicios/serviciosguias1.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosguias3.jpg'),
                    database_path('seeders/fixtures/servicios/serviciosguias4.jpeg'),
                    database_path('seeders/fixtures/servicios/serviciosguias5.jpeg'),
                ],
            ],



            // Agrega más servicios según necesites...
        ];

        foreach ($fixtures as $f) {
            // 1) Crear el registro en 'servicios' sin manejar aún las imágenes
            $servicio = Servicio::create([
                'emprendimientos_id'      => $f['emprendimientos_id'],
                'nombre'                  => $f['nombre'],
                'descripcion'             => $f['descripcion'],
                'precio'                  => $f['precio'],
                'capacidad_maxima'        => $f['capacidad_maxima'],
                'duracion_servicio'       => $f['duracion_servicio'],
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

            // 2) Por cada ruta de imagen, guardarla en storage y registrar en images + pivote
            foreach ($f['imagenes'] as $rutaLocal) {
                // 2.1) Copiar el archivo a storage/app/public/servicios/{id}/...
                $publicPath = Storage::disk('public')->putFile(
                    'servicios/' . $servicio->getKey(),
                    new File($rutaLocal)
                );

                // 2.2) Crear registro en la tabla 'images'
                $img = Images::create([
                    'url'    => $publicPath,
                    'titulo' => $servicio->nombre . ' (Imagen)',
                ]);

                // 2.3) Insertar en la tabla pivote 'imageables'
                DB::table('imageables')->insert([
                    'images_id'      => $img->id,
                    'imageable_id'   => $servicio->getKey(),
                    'imageable_type' => Servicio::class,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }
}
