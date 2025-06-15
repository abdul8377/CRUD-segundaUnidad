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
        Schema::create('experiencias_usuario', function (Blueprint $table) {
            $table->bigIncrements('experiencias_usuario_id');
            $table->unsignedBigInteger('users_id');
            $table->string('titulo', 150);
            $table->text('contenido');
            $table->string('imagen_destacada', 255)->nullable();
            $table->enum('estado', ['pendiente', 'publicado', 'rechazado'])->default('pendiente');
            $table->timestamp('fecha_publicacion')->nullable();
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
        Schema::dropIfExists('experiencias_usuario');
    }
};
