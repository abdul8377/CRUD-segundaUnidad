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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->bigIncrements('paquetes_id');
            $table->unsignedBigInteger('emprendimientos_id');
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_total', 10, 2)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('emprendimientos_id')->references('emprendimientos_id')->on('emprendimientos');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
