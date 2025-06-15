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
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('eventos_id');
            $table->unsignedBigInteger('emprendimientos_id');
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->time('hora');
            $table->integer('capacidad_maxima');
            $table->string('lugar', 255)->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'cancelado'])->default('activo');
            $table->foreign('emprendimientos_id')->references('emprendimientos_id')->on('emprendimientos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
