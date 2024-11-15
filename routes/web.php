<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Business\BusinessSetupController;
use App\Http\Controllers\Business\BusinessServiceController;
use App\Http\Controllers\Client\ClientServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CityController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

function roleBasedRoutes(string $prefix, int $roleId, string $namePrefix, callable $routes)
{
    Route::middleware(["role:$roleId"])
        ->prefix($prefix)
        ->name("$namePrefix.")
        ->group($routes);
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-cities/{countryCode}', [CityController::class, 'getCities']);

// Authenticated and Verified Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Define Role-Based Routes Using the Helper Function

    roleBasedRoutes('admin', User::ROLE_ADMIN, 'admin', function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::resource('users', UserController::class);
        Route::patch('users/{user}/update-password', [PasswordController::class, 'update'])
            ->name('users.update-password');
        Route::patch('users/{user}/update-avatar', [UserController::class, 'updateUserAvatar'])
            ->name('users.update-avatar');
    });

    roleBasedRoutes('business', User::ROLE_BUSINESS, 'business', function () {
        // Routes accessible only after setup is complete
        Route::middleware('business.setup.complete')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::resource('services', BusinessServiceController::class);
        });

        // Routes accessible only if setup is not complete
        Route::middleware('business.setup.incomplete')->group(function () {
            Route::get('setup/step-one', [BusinessSetupController::class, 'stepOne'])->name('setup.stepOne');
            Route::post('setup/step-one', [BusinessSetupController::class, 'storeStepOne'])->name('setup.storeStepOne');
            Route::get('setup/step-two', [BusinessSetupController::class, 'stepTwo'])->name('setup.stepTwo');
            Route::post('setup/step-two', [BusinessSetupController::class, 'storeStepTwo'])->name('setup.storeStepTwo');
        });
    });

    roleBasedRoutes('client', User::ROLE_CLIENT, 'client', function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('services', [ClientServiceController::class, 'index'])->name('services');
        Route::get('services/{service}', [ClientServiceController::class, 'show'])->name('services.show');
        Route::post('services/{service}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

        Route::get('services/{service}/available-slots', [BookingController::class, 'availableSlots'])
            ->name('services.available-slots');

        Route::post('services/{service}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    });

});

require __DIR__ . '/auth.php';
