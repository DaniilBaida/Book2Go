<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Business;
use App\Http\Controllers\Client;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\AvatarController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Grupo de rotas para cliente
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

    // Grupo de rotas para negócio
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

    // Grupo de rotas para administração
    Route::prefix('admin')
        ->middleware('role:3')
        ->name('admin.')
        ->group(function () {
            Route::get('dashboard', [Admin\DashboardController::class, 'index'])
                ->name('dashboard');

            // Rotas de perfil para o admin
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            // Rotas para gerenciamento de usuários
            Route::resource('users', UserController::class);

            // Atualização de senha para um usuário específico (feito pelo admin)
            Route::patch('/users/{user}/update-password', [PasswordController::class, 'update'])
                ->name('users.update-password');

            // Atualização de avatar para um usuário específico (feito pelo admin)
            Route::patch('/users/{user}/update-avatar', [UserController::class, 'updateUserAvatar'])
                ->name('users.update-avatar');
        });
});

require __DIR__.'/auth.php';
