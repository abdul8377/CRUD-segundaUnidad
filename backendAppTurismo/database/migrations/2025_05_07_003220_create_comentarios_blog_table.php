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
        Schema::create('comentarios_blog', function (Blueprint $table) {
            $table->bigIncrements('comentarios_blog_id');
            $table->unsignedBigInteger('blogs_id');
            $table->unsignedBigInteger('users_id');
            $table->text('contenido');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('blogs_id')->references('blogs_id')->on('blogs');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios_blog');
    }
};
