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
        Schema::create('datos_contactanos', function (Blueprint $table) {
            $table->bigIncrements('datos_contactanos_id');
            $table->string('telefono', 20);
            $table->string('correo_contacto', 100);
            $table->string('horario_atencion', 100)->nullable();
            $table->string('dias_laborales', 100);
            $table->string('link_whatsapp', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_contactanos');
    }
};
