<?php

namespace Database\Factories;

use App\Models\PerfilEmprendedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PerfilEmprendedor>
 */
class PerfilEmprendedorFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a la factoría.
     *
     * @var string
     */
    protected $model = PerfilEmprendedor::class;

    /**
     * Definir los datos predeterminados de la factoría.
     *
     * @return array
     */
    public function definition(): array
    {
        // Obtén los usuarios existentes que deseas asociar, sin repetir
        $userIds = [2, 3, 4, 5, 6];

        return [
            'users_id' => array_shift($userIds), // Usamos array_shift para obtener un ID único sin repetir
            'dni' => $this->faker->unique()->numerify('###########'), // Genera un DNI aleatorio
            'telefono_contacto' => $this->faker->phoneNumber, // Genera un teléfono aleatorio
            'experiencia' => $this->faker->paragraph, // Descripción de la experiencia
            'estado_validacion' => $this->faker->randomElement(['pendiente', 'aprobado', 'rechazado']),
            'descripcion_emprendimiento' => $this->faker->sentence, // Descripción del emprendimiento
            'gmail_contacto' => $this->faker->email, // Genera un correo aleatorio
            'gmail_confirmado' => $this->faker->boolean, // Estado de confirmación del correo
            'codigo' => $this->faker->unique()->word, // Código único para el emprendedor
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
