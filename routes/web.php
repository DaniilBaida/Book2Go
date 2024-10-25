<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Business;
use App\Http\Controllers\Client;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('client')
        ->middleware('role:1')
        ->name('client.')
        ->group(function () {
            Route::get('dashboard', [Client\DashboardController::class, 'index'])
                ->name('dashboard');
            Route::get('/profile', [Client\ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [Client\ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [Client\ProfileController::class, 'destroy'])->name('profile.destroy');
        });

   Route::prefix('business')
        ->middleware('role:2')
        ->name('business.')
        ->group(function () {
            Route::get('dashboard', [Business\DashboardController::class, 'index'])
                ->name('dashboard');
            Route::get('/profile', [Business\ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [Business\ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [Business\ProfileController::class, 'destroy'])->name('profile.destroy');
        });

    Route::prefix('admin')
        ->middleware('role:3')
        ->name('admin.')
        ->group(function () {
            Route::get('dashboard', [Admin\DashboardController::class, 'index'])
                ->name('dashboard');
            Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [Admin\ProfileController::class, 'destroy'])->name('profile.destroy');

            // User management routes
            Route::resource('users', Admin\UserController::class);
        });
});


require __DIR__.'/auth.php';
