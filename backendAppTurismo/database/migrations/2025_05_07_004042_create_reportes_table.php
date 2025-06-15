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
        Schema::create('reportes', function (Blueprint $table) {
            $table->bigIncrements('reportes_id');
            $table->unsignedBigInteger('users_id');
            $table->enum('tipo_reporte', ['emprendimiento', 'item', 'usuario']);
            $table->unsignedBigInteger('referencia_id');
            $table->text('motivo');
            $table->enum('estado', ['pendiente', 'atendido', 'sancionado'])->default('pendiente');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('users_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
