<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitud_emprendimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('emprendimientos_id');
            $table->unsignedBigInteger('users_id');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            $table->enum('rol_solicitado', ['propietario', 'colaborador'])->default('colaborador');
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();

            $table->foreign('emprendimientos_id')->references('emprendimientos_id')->on('emprendimientos')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitud_emprendimiento');
    }
};
