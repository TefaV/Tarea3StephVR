<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditorialController;

// Ruta raíz redirige al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard (lista de libros)
    Route::get('/dashboard', [LibroController::class, 'index'])->name('dashboard');

    // CRUD recursos
    Route::resource('libros', LibroController::class);
    Route::resource('autors', AutorController::class);
    Route::resource('editorials', EditorialController::class);
});

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';
