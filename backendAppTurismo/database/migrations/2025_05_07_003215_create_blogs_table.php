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
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('blogs_id');
            $table->unsignedBigInteger('emprendimientos_id');
            $table->string('titulo', 150);
            $table->text('contenido');
            $table->string('imagen_destacada', 255)->nullable();
            $table->date('fecha_publicacion');
            $table->enum('estado', ['borrador', 'publicado'])->default('borrador');
            $table->foreign('emprendimientos_id')->references('emprendimientos_id')->on('emprendimientos');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
