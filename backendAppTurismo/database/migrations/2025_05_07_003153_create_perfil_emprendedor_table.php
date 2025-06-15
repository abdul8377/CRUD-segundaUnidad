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
        Schema::create('perfil_emprendedor', function (Blueprint $table) {
            $table->bigIncrements('perfil_emprendedor_id');
            $table->unsignedBigInteger('users_id');
            $table->string('dni', 20);
            $table->string('telefono_contacto', 20)->nullable();
            $table->text('experiencia')->nullable();
            $table->enum('estado_validacion', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('descripcion_emprendimiento')->nullable();
            $table->string('gmail_contacto', 255)->nullable();
            $table->boolean('gmail_confirmado')->default(false);
            $table->string('codigo', 100)->nullable();
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
        Schema::dropIfExists('perfil_emprendedor');
    }
};
