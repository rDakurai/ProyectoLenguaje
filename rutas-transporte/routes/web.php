<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParadaController;
use App\Http\Controllers\HorarioController;

// Públicas
Route::get('/', [RutaController::class, 'index'])->name('rutas.index');
Route::get('/rutas/{ruta}', [RutaController::class, 'show'])->name('rutas.show');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {

    // CRUD de Rutas
    Route::get('/rutas/create',        [RutaController::class, 'create'])->name('rutas.create');
    Route::post('/rutas',              [RutaController::class, 'store'])->name('rutas.store');
    Route::get('/rutas/{ruta}/edit',   [RutaController::class, 'edit'])->name('rutas.edit');
    Route::put('/rutas/{ruta}',        [RutaController::class, 'update'])->name('rutas.update');
    Route::delete('/rutas/{ruta}',     [RutaController::class, 'destroy'])->name('rutas.destroy');

    // Paradas (crear / guardar)
    Route::get('/rutas/{ruta}/paradas/create', [ParadaController::class, 'createForRuta'])->name('rutas.paradas.create');
    Route::post('/rutas/{ruta}/paradas',       [ParadaController::class, 'storeForRuta'])->name('rutas.paradas.store');

    // Paradas (editar / actualizar)
    Route::get('/rutas/{ruta}/paradas/{parada}/edit', [ParadaController::class, 'editForRuta'])->name('rutas.paradas.edit');
    Route::put('/rutas/{ruta}/paradas/{parada}',      [ParadaController::class, 'updateForRuta'])->name('rutas.paradas.update');

    // Paradas (eliminar - por sentido vía request)
    Route::delete('/rutas/{ruta}/paradas/{parada}',   [ParadaController::class, 'destroyForRuta'])->name('rutas.paradas.destroy');

    // Horarios (crear / guardar)
    Route::get('/rutas/{ruta}/horarios/create', [HorarioController::class, 'createForRuta'])->name('rutas.horarios.create');
    Route::post('/rutas/{ruta}/horarios',       [HorarioController::class, 'storeForRuta'])->name('rutas.horarios.store');

    // Horarios (editar / actualizar)
    Route::get('/rutas/{ruta}/horarios/{horario}/edit', [HorarioController::class, 'editForRuta'])->name('rutas.horarios.edit');
    Route::put('/rutas/{ruta}/horarios/{horario}',      [HorarioController::class, 'updateForRuta'])->name('rutas.horarios.update');

    // Horarios (eliminar)
    Route::delete('/rutas/{ruta}/horarios/{horario}',   [HorarioController::class, 'destroyForRuta'])->name('rutas.horarios.destroy');
});



