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
        Schema::create('slider', function (Blueprint $table) {
            $table->bigIncrements('slider_id');

            // Contenido del slider
            $table->string('titulo', 150)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('link', 255)->nullable(); // enlace opcional

            // Gestión y organización
            $table->unsignedInteger('orden')->default(0);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // Timestamps estándar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider');
    }
};
