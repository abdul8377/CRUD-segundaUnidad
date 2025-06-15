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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->bigIncrements('descuentos_id');
            $table->unsignedBigInteger('productos_id')->nullable();
            $table->unsignedBigInteger('servicios_id')->nullable();
            $table->unsignedBigInteger('emprendimientos_id')->nullable();
            $table->string('nombre_descuento', 255);
            $table->text('descripcion')->nullable();
            $table->decimal('porcentaje', 5, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('productos_id')->references('productos_id')->on('productos');
            $table->foreign('servicios_id')->references('servicios_id')->on('servicios');
            $table->foreign('emprendimientos_id')->references('emprendimientos_id')->on('emprendimientos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
