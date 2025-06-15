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
        // Tabla de usuarios
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('user')->unique();             // Código cifrado (hash)
            $table->string('user_code_plain')->nullable()->unique(); // Código original texto plano único
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabla de recuperación de contraseñas
        Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->index();     // Índice para búsqueda rápida
        $table->string('token');
        $table->timestamp('created_at')->nullable();
        });

        // Tabla de sesiones (Laravel > 10)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();             // ID de sesión
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();      // Info del navegador
            $table->longText('payload');                 // Datos de sesión
            $table->integer('last_activity')->index();   // Timestamp de última actividad
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
