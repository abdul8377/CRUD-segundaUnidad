<?php

use App\Http\Controllers\CategoriaServicioController;
use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\EmprendimientoUsuario\EmprendimientoUsuarioController;
use App\Http\Controllers\Municipalidad\MunicipalidadDescripcionController;
use App\Http\Controllers\Municipalidad\SliderController;
use App\Http\Controllers\ProductoServicio\CategoriaProductoController;
use App\Http\Controllers\ProductoServicio\ServicioController;
use App\Http\Controllers\TipoDeNegocioController;
use App\Http\Controllers\TuristaController;
use App\Livewire\Categoria\CategoriaList;
use App\Providers\VoltServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


// Ruta pública (landing)
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/password/reset', function (Request $request) {
    $token = $request->token;
    return view('auth.passwords.reset', compact('token'));
})->name('password.reset');

// Ruta al dashboard (requiere autenticación y verificación)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

 // Redirección por defecto a perfil de configuración
Route::redirect('settings', 'settings/profile');

// Rutas de configuración de usuario (Livewire Volt)
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');




// Grupo de rutas protegidas por autenticación + rol Administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {

    // Ruta Livewire de categorías
    Route::get('/categorias-p-s', CategoriaList::class)->name('categorias-p');

    // CRUD de tipos de negocio
    Route::resource('tipos-de-negocio', TipoDeNegocioController::class)->parameters([
        'tipos-de-negocio' => 'tipoDeNegocio'
    ]);

    // CRUD de emprendedores
    Route::prefix('emprendedores')->name('emprendedores.')->group(function() {
        Route::get('/', [EmprendedorController::class, 'index'])->name('index');
        Route::get('/create', [EmprendedorController::class, 'create'])->name('create');
        Route::post('/', [EmprendedorController::class, 'store'])->name('store');
        Route::get('/{emprendedor}', [EmprendedorController::class, 'show'])->name('show');
        Route::get('/{emprendedor}/edit', [EmprendedorController::class, 'edit'])->name('edit');
        Route::put('/{emprendedor}', [EmprendedorController::class, 'update'])->name('update');
        Route::put('/{emprendedor}/status', [EmprendedorController::class, 'updateStatus'])->name('updateStatus');
    });

    // Crear emprendimiento y asignar usuario/rol
    Route::get('/emprendimiento-usuario/create/{emprendedor_id}', [EmprendimientoUsuarioController::class, 'create'])->name('emprendimiento-usuarios.create');
    Route::post('/emprendimiento-usuario', [EmprendimientoUsuarioController::class, 'store'])->name('emprendimiento-usuarios.store');

    // Listar turistas y gestionar su información
    Route::get('turistas', [TuristaController::class, 'index'])->name('turistas.index');
    Route::get('turistas/{turista}', [TuristaController::class, 'show'])->name('turistas.show');
    Route::get('turistas/{turista}/edit', [TuristaController::class, 'edit'])->name('turistas.edit');
    Route::put('turistas/{turista}', [TuristaController::class, 'update'])->name('turistas.update');

    // CRUD de categorías de servicios
    Route::resource('categorias-servicios', CategoriaServicioController::class)->parameters([
        'categorias-servicios' => 'categoriaDeServicio'
    ]);

    Route::get('/municipalidad', [MunicipalidadDescripcionController::class, 'index'])->name('municipalidad.index');
    Route::post('/municipalidad', [MunicipalidadDescripcionController::class, 'store'])->name('municipalidad.store');
    Route::put('/municipalidad/{id}', [MunicipalidadDescripcionController::class, 'update'])->name('municipalidad.update');
    Route::post('/municipalidad/{id}/imagen', [MunicipalidadDescripcionController::class, 'uploadImage'])->name('municipalidad.imagen');
    Route::get('/municipalidad/galeria', [MunicipalidadDescripcionController::class, 'galeria'])->name('municipalidad.galeria');
    Route::delete('/municipalidad/imagen/{id}', [MunicipalidadDescripcionController::class, 'destroyImagen'])->name('municipalidad.imagen.destroy');
    Route::put('/municipalidad/{id}/toggle-mantenimiento', [MunicipalidadDescripcionController::class, 'toggleMantenimiento'])->name('municipalidad.toggleMantenimiento');

     // Rutas CRUD para Slider de Municipalidad
    // En tu archivo de rutas web (web.php), dentro del grupo de rutas para Administrador
Route::prefix('municipalidad/slider')->name('slider.')->group(function () {
    Route::get('/', [SliderController::class, 'index'])->name('index');
    Route::get('/create', [SliderController::class, 'create'])->name('create');
    Route::post('/', [SliderController::class, 'store'])->name('store');
    Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('edit');
    Route::put('/{slider}', [SliderController::class, 'update'])->name('update');
    Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('destroy');

    // ✅ Ruta para mostrar sliders anteriores por orden
    Route::get('/editar-orden/{orden}', [SliderController::class, 'editarOrden'])->name('editarOrden');

    // ✅ Ruta para activar un slider existente (pasar a visible)
    Route::post('/activar-slider/{slider}', [SliderController::class, 'activar'])->name('activar');
});

    Route::resource('categorias-productos', CategoriaProductoController::class)->parameters([
    'categorias-productos' => 'categoriaProducto'
]);
});

Route::middleware(['auth', 'role:Emprendedor'])->prefix('servicios')->group(function () {
    Route::get('/', [ServicioController::class, 'index'])->name('servicios.index');
    Route::get('/crear', [ServicioController::class, 'create'])->name('servicios.create');
    Route::post('/', [ServicioController::class, 'store'])->name('servicios.store');
    Route::get('/{servicio}/editar', [ServicioController::class, 'edit'])->name('servicios.edit');
    Route::put('/{servicio}', [ServicioController::class, 'update'])->name('servicios.update');
    Route::delete('/{servicio}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
});

// Rutas de autenticación (login, register, forgot password, etc.)
require __DIR__.'/auth.php';
