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
        Schema::create('detalle_servicio_paquete', function (Blueprint $table) {
            $table->bigIncrements('detalle_servicio_paquete_id');
            $table->unsignedBigInteger('paquetes_id');
            $table->unsignedBigInteger('servicios_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('paquetes_id')->references('paquetes_id')->on('paquetes');
            $table->foreign('servicios_id')->references('servicios_id')->on('servicios');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_servicio_paquete');
    }
};
