<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PipBoyController;

// Publiczny dostęp (Frontend)
Route::get('/', [PipBoyController::class, 'index'])->name('home');
Route::get('/stats', [PipBoyController::class, 'stats'])->name('stats');
Route::get('/items', [PipBoyController::class, 'items'])->name('items');
Route::get('/data', [PipBoyController::class, 'data'])->name('data');

// Proste uwierzytelnianie (dla testów)
Route::get('/login', function() { return "Proszę się zalogować (tu powinien być formularz)"; })->name('login');

// Panel Administratora (Dostępny tylko dla is_admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Witaj w panelu administratora Vault-Tec. Tutaj możesz edytować tabele.";
    })->name('admin.dashboard');
});