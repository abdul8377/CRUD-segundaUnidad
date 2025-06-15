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
        Schema::create('terminos_condiciones', function (Blueprint $table) {
            $table->bigIncrements('terminos_condiciones_id');
            $table->string('titulo', 150);
            $table->text('contenido');
            $table->string('version', 10)->default('1.0');
            $table->boolean('vigente')->default(true);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminos_condiciones');
    }
};
