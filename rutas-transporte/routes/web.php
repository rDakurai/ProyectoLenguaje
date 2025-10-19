<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutaController;

Route::get('/', [RutaController::class, 'index'])->name('rutas.index');
Route::get('/rutas/{ruta}', [RutaController::class, 'show'])->name('rutas.show');
