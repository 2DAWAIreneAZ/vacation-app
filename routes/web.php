<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────
// Pública
// ──────────────────────────────────────────────
Route::get('/', [VacationController::class, 'welcome'])->name('welcome');

// ──────────────────────────────────────────────
// Autenticadas
// ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil — rutas que Breeze genera en el ProfileController
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Paquetes vacacionales
    Route::resource('vacations', VacationController::class);

    // Tipos
    Route::resource('types', TypeController::class);

    // Usuarios — solo admin
    Route::middleware('admin')->resource('users', UserController::class);

    // Reservas
    Route::get('/reserves', [ReserveController::class, 'index'])->name('reserves.index');
    Route::post('/reserves', [ReserveController::class, 'store'])->name('reserves.store');
    Route::delete('/reserves/{reserve}', [ReserveController::class, 'destroy'])->name('reserves.destroy');

    // Comentarios
    Route::post('/vacations/{vacation}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Breeze registra aquí: login, register, logout, forgot-password, reset-password
require __DIR__.'/auth.php';