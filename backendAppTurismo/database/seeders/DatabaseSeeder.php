<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\CategoriaServicio;
use App\Models\PerfilEmprendedor;
use App\Models\TipoDeNegocio;
use App\Models\User;
use Database\Seeders\TiposDeNegocioSeeder;  // Asegúrate de que la clase esté importada correctamente

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Primero permisos y roles
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);

        // Crear usuarios
        $this->call(UserSeeder::class);

        // Crear categorías de servicio
        $this->call(CategoriaServicioSeeder::class);
        $this->call(CategoriasProductosSeeder::class);

        // Llamar al seeder TiposDeNegocioSeeder
        $this->call(TiposDeNegocioSeeder::class); // Esto reemplaza la fábrica

        // Crear el perfil de los emprendedores
        // $this->call(PerfilEmprendedorSeeder::class);
        $this->call(EmprendedorSeeder::class);

        $this->call(EmprendimientoSeeder::class);

        $this->call(EmprendimientoUsuariosSeeder::class);


        // Municipalidad (solo un registro)
        $this->call(MunicipalidadDescripcionSeeder::class);
        // Zonas turisticas
        $this->call(ZonasTuristicasSeeder::class);
        $this->call(ProductoSeeder::class);

        $this->call(ServicioSeeder::class);
    }
}

