<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Public route
Route::view('/', 'welcome');

Route::get('/dashboard', fn() => redirect()->route('message.create'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/create', [MessageController::class, 'create'])->name('message.create');
        Route::post('/', [MessageController::class, 'store'])->name('message.store');
        Route::get('/unread', [MessageController::class, 'unreadMessages'])->name('messages.unread');
        Route::get('/{identifier}', [MessageController::class, 'readMessage'])->name('message.read');
    });

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';
