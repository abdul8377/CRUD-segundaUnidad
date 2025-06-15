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
        Schema::create('favoritos', function (Blueprint $table) {
            $table->bigIncrements('favoritos_id');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('productos_id')->nullable();
            $table->unsignedBigInteger('servicios_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('productos_id')->references('productos_id')->on('productos');
            $table->foreign('servicios_id')->references('servicios_id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
