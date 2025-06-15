<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDeNegocioSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipos_de_negocio')->insert([

            [
                'nombre' => 'Productos',
                'descripcion' => 'Venta de productos típicos andinos, como artesanías, textiles y alimentos locales.',
                'created_at' => now(),
                'updated_at' => now(),
                /* id 1 */
            ],
            [
                'nombre' => 'Gastronomía',
                'descripcion' => 'Establecimiento dedicado a la preparación y venta de platos típicos andinos, como la torreja de quinua y el t’himpo de pejerrey.',
                'created_at' => now(),
                'updated_at' => now(),
                /* id 2 */
            ],
            [
                'nombre' => 'Experiencias',
                'descripcion' => 'Actividades y experiencias culturales que conectan a los turistas con las costumbres locales y las comunidades.',
                'created_at' => now(),
                'updated_at' => now(),
                /* id 3 */
            ],
            [
                'nombre' => 'Alojamiento',
                'descripcion' => 'Establecimientos que ofrecen hospedaje en casas familiares, hoteles rurales y otros espacios típicos de la zona.',
                'created_at' => now(),
                'updated_at' => now(),
                /* id 4 */
            ],
            [
                'nombre' => 'Guías',
                'descripcion' => 'Personas capacitadas para acompañar y orientar a los turistas en las diferentes actividades turísticas y culturales.',
                'created_at' => now(),
                'updated_at' => now(),
                /* id 5 */
            ],


        ]);
    }
}
