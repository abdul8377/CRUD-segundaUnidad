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
        Schema::create('tipo_cambio', function (Blueprint $table) {
            $table->bigIncrements('tipo_cambio_id');
            $table->unsignedBigInteger('monedas_id')->nullable();
            $table->decimal('tasa_cambio', 10, 4);
            $table->timestamp('fecha')->useCurrent();
            $table->foreign('monedas_id')->references('monedas_id')->on('monedas');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_cambio');
    }
};
