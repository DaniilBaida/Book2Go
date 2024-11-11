<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Business\DashboardController as BusinessDashboardController;
use App\Http\Controllers\Business\BusinessSetupController;
use App\Http\Controllers\Business\ProfileController as BusinessProfileController;
use App\Http\Controllers\Client;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\AvatarController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

        Route::get('dashboard', [BusinessDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profile', [BusinessProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [BusinessProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [BusinessProfileController::class, 'destroy'])->name('profile.destroy');

        // Rotas do assistente de configuração inicial
        Route::get('setup/step-one', [BusinessSetupController::class, 'stepOne'])->name('setup.stepOne');
        Route::post('setup/step-one', [BusinessSetupController::class, 'storeStepOne'])->name('setup.storeStepOne');

        Route::get('setup/step-two', [BusinessSetupController::class, 'stepTwo'])->name('setup.stepTwo');
        Route::post('setup/step-two', [BusinessSetupController::class, 'storeStepTwo'])->name('setup.storeStepTwo');

        Route::get('setup/step-three', [BusinessSetupController::class, 'stepThree'])->name('setup.stepThree');
        Route::post('setup/step-three', [BusinessSetupController::class, 'storeStepThree'])->name('setup.storeStepThree');

        Route::get('setup/confirm', [BusinessSetupController::class, 'confirm'])->name('setup.confirm');
        Route::post('setup/finish', [BusinessSetupController::class, 'finish'])->name('setup.finish');
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
