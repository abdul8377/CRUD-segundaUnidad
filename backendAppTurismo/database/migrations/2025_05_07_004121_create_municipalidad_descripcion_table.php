<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('municipalidad_descripcion', function (Blueprint $table) {
            $table->bigIncrements('municipalidad_descripcion_id');

            // Nuevos campos de configuración general
            $table->string('nombre')->nullable();
            $table->string('color_primario')->nullable();
            $table->string('color_secundario')->nullable();
            $table->boolean('mantenimiento')->default(false);

            // Información de la municipalidad
            $table->string('direccion', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('ruc', 20)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('nombre_alcalde', 100)->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('anio_gestion', 10)->nullable();

            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipalidad_descripcion');
    }
};
