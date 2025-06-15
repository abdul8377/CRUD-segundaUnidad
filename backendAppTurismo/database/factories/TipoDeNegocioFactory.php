<?php


namespace Database\Factories;

use App\Models\TipoDeNegocio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoDeNegocio>
 */
class TipoDeNegocioFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a la factoría.
     *
     * @var string
     */
    protected $model = TipoDeNegocio::class;

    /**
     * Definir los datos predeterminados de la factoría.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word, // Genera una palabra aleatoria para el nombre
            'descripcion' => $this->faker->paragraph, // Genera un párrafo aleatorio para la descripción (opcional)
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
