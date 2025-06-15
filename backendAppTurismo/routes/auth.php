<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    // Paso 1: Formulario donde el usuario ingresa su nombre de usuario
    Route::get('login', [LoginController::class, 'showUserForm'])->name('login');
    Route::post('login/validate-user', [LoginController::class, 'validateUser'])->name('login.validate.user');

    // Paso 2: Formulario de contraseña si el usuario existe
    Route::get('login/{user}', [LoginController::class, 'showPasswordForm'])->name('login.password');
    Route::post('login/{user}', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/password/reset', [LoginController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [LoginController::class, 'resetPassword'])->name('password.update');

    // Registro
    Route::get('register', [RegisterController::class, 'show'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Recuperación de contraseña con Volt
    Volt::route('forgot-password', 'auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')->name('password.confirm');
});

Route::post('logout', App\Livewire\Actions\Logout::class)->name('logout');
