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
        Schema::create('perfil_turista', function (Blueprint $table) {
            $table->bigIncrements('perfil_turista_id');
            $table->unsignedBigInteger('users_id');
            $table->string('nacionalidad', 100)->nullable();
            $table->integer('edad')->nullable();
            $table->text('intereses')->nullable();
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
        Schema::dropIfExists('perfil_turista');
    }
};
