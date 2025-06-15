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
        Schema::create('monedas', function (Blueprint $table) {
            $table->bigIncrements('monedas_id');
            $table->string('codigo', 3)->nullable(); // Ej: 'PEN', 'USD', 'EUR'
            $table->string('nombre', 50)->nullable();
            $table->string('simbolo', 5)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monedas');
    }
};
