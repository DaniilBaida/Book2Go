<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Business;
use App\Http\Controllers\Client;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\AvatarController; // Importando o AvatarController
use App\Http\Controllers\Auth\PasswordController; // Importando o PasswordController
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
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            // Rota para atualizar o avatar do perfil do admin usando AvatarController
            Route::patch('/profile/update-avatar', [AvatarController::class, 'update'])
                ->name('profile.update-avatar');

            // Rotas para gerenciamento de usuários
            Route::resource('users', Admin\UserController::class);
            Route::patch('/users', [Admin\UserController::class, 'update'])->name('user.update');
            Route::patch('/users/{user}/update-password', [PasswordController::class, 'update']) // Adicione isso
                ->name('users.update-password');
            
            // Rota para atualizar o avatar de um usuário específico usando AvatarController
            Route::patch('/users/{user}/update-avatar', [AvatarController::class, 'update'])
                ->name('users.update-avatar');
        });
});

require __DIR__.'/auth.php';
