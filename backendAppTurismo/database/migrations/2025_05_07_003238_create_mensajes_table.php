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
        Schema::create('mensajes', function (Blueprint $table) {
            $table->bigIncrements('mensajes_id');
            $table->unsignedBigInteger('conversaciones_id');
            $table->enum('emisor', ['usuario', 'emprendimiento']);
            $table->text('contenido');
            $table->string('imagen_url', 255)->nullable();
            $table->boolean('leido')->default(false);
            $table->timestamp('enviado_en')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('conversaciones_id')->references('conversaciones_id')->on('conversaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
