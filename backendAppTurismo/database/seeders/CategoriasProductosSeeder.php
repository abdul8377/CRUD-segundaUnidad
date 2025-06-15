<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasProductosSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias_productos')->insert([
            [
                'nombre' => 'Artesanías Textiles',
                'descripcion' => 'Productos elaborados con técnicas tradicionales, como ponchos, frazadas y sombreros bordados.',
                'created_at' => now(),
                'updated_at' => now(),

                /* id 1 */
            ],
            [
                'nombre' => 'Cerámica',
                'descripcion' => 'Artículos de barro cocido, como ollas, platos y figuras decorativas, elaborados por artesanos locales.',
                'created_at' => now(),
                'updated_at' => now(),

                /* id 2 */
            ],
            [
                'nombre' => 'Productos Pesqueros',
                'descripcion' => 'Pescado fresco y otros productos del Lago Titicaca, como el pejerrey y el camarón.',
                'created_at' => now(),
                'updated_at' => now(),

                /* id 3 */
            ],
            [
                'nombre' => 'Alimentos Típicos',
                'descripcion' => 'Alimentos preparados con ingredientes locales, como la quinua, el maíz, el camote y otros productos autóctonos.',
                'created_at' => now(),
                'updated_at' => now(),

                /* id 4 */
            ],
            [
                'nombre' => 'Ropa Típica',
                'descripcion' => 'Ropa y accesorios tradicionales como ponchos, sombreros, y mantas, hechos a mano por artesanos locales.',
                'created_at' => now(),
                'updated_at' => now(),

                /* id 5 */
            ]
        ]);
    }
}
