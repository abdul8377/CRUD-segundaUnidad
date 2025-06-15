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
        Schema::create('detalle_reservas', function (Blueprint $table) {
            $table->bigIncrements('detalle_reservas_id');
            $table->unsignedBigInteger('reserva_id');
            $table->unsignedBigInteger('productos_id')->nullable();
            $table->unsignedBigInteger('servicios_id')->nullable();
            $table->integer('cantidad')->default(1);
            $table->time('hora_reserva');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('reserva_id')->references('reservas_id')->on('reservas');
            $table->foreign('productos_id')->references('productos_id')->on('productos');
            $table->foreign('servicios_id')->references('servicios_id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_reservas');
    }
};
