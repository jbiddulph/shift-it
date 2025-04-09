<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TodoController::class, 'index'])->name('dashboard');
});

Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
