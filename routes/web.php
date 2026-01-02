<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PipBoyController;

// --- Widoki Główne ---
Route::get('/', [PipBoyController::class, 'index'])->name('home');
Route::get('/stats', [PipBoyController::class, 'stats'])->name('stats');
Route::get('/items', [PipBoyController::class, 'items'])->name('items');
Route::get('/data', [PipBoyController::class, 'data'])->name('data');

// --- Symulacja Logowania ---
// Pozwala przełączyć się na innego użytkownika klikając w zakładce GENERAL
Route::get('/sim-login/{id}', [PipBoyController::class, 'loginUser'])->name('login.sim');

// --- Akcje Administracyjne (Tylko dla zalogowanych) ---
Route::middleware(['auth'])->group(function () {
    Route::delete('/items/{id}', [PipBoyController::class, 'deleteItem'])->name('items.delete');
    Route::put('/notes/{id}', [PipBoyController::class, 'updateNote'])->name('notes.update');
});
