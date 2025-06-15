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
        Schema::create('emprendimiento_usuarios', function (Blueprint $table) {
            $table->bigIncrements(column: 'emprendimiento_usuarios_id');
            $table->unsignedBigInteger('emprendimientos_id');
            $table->unsignedBigInteger('users_id');
            $table->enum('rol_emprendimiento', ['propietario', 'colaborador'])->default('propietario');
            $table->timestamp('fecha_asignacion')->useCurrent();
            $table->foreign('emprendimientos_id')->references('emprendimientos_id')->on('emprendimientos');
            $table->foreign('users_id')->references('id')->on('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprendimiento_usuarios');
    }
};
