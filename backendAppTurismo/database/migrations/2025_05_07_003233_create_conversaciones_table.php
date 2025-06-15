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
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->bigIncrements('conversaciones_id');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('emprendimientos_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('emprendimientos_id')->references('emprendimientos_id')->on('emprendimientos');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversaciones');
    }
};
