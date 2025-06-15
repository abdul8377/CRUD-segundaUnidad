<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MunicipalidadDescripcion;

class MunicipalidadDescripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica que no haya ya un registro
        if (MunicipalidadDescripcion::count() === 0) {
            MunicipalidadDescripcion::create([
                'nombre' => 'Municipalidad Distrital de Ejemplo',
                'color_primario' => '#3490dc',
                'color_secundario' => '#6c757d',
                'mantenimiento' => false,
                'direccion' => 'Av. Principal 123',
                'descripcion' => 'Esta municipalidad trabaja por el bienestar de todos los ciudadanos.',
                'ruc' => '12345678901',
                'correo' => 'contacto@municipalidad.gob.pe',
                'telefono' => '012345678',
                'nombre_alcalde' => 'Juan Pérez',
                'facebook_url' => 'https://www.facebook.com/municipalidad',
                'anio_gestion' => '2023-2026',
            ]);
        }
    }
}
