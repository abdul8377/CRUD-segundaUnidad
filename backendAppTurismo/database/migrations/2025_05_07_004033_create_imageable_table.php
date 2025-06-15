<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imageables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('images_id');
            $table->unsignedBigInteger('imageable_id');
            $table->string('imageable_type');
            $table->timestamps();

            $table->foreign('images_id')->references('id')->on('images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imageables');
    }
};
