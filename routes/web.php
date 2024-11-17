<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Business\BusinessBookingController;
use App\Http\Controllers\Business\BusinessSetupController;
use App\Http\Controllers\Business\BusinessServiceController;
use App\Http\Controllers\Business\BusinessDetailsController;
use App\Http\Controllers\Business\BusinessDiscountController;
use App\Http\Controllers\Client\ClientBookingController;
use App\Http\Controllers\Client\ClientServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CityController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Helper function to define routes based on user roles
function roleBasedRoutes(string $prefix, int $roleId, string $namePrefix, callable $routes)
{
    Route::middleware(["role:$roleId"])
        ->prefix($prefix)
        ->name("$namePrefix.")
        ->group($routes);
}

// Public route for the welcome page
Route::get('/', function () {
    return view('welcome');
});

// Public route to fetch cities based on country code
Route::get('/get-cities/{countryCode}', [CityController::class, 'getCities']);

// Authenticated and verified routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Admin-specific routes
    roleBasedRoutes('admin', User::ROLE_ADMIN, 'admin', function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Admin dashboard
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile

        Route::resource('services', ServiceController::class)->only(['index', 'show', 'destroy']); // Service management

        Route::resource('users', UserController::class); // User resource management
        Route::patch('users/{user}/update-password', [PasswordController::class, 'update'])->name('users.update-password'); // Update user password
        Route::patch('users/{user}/update-avatar', [UserController::class, 'updateUserAvatar'])->name('users.update-avatar'); // Update user avatar

        // Discount Codes for Admin
        Route::resource('discounts', AdminDiscountController::class)->except(['show']);
    });

    // Business-specific routes
    roleBasedRoutes('business', User::ROLE_BUSINESS, 'business', function () {
        // Routes for businesses with complete setup
        Route::middleware('business.setup.complete')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Business dashboard
            Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile
            Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
            Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile

            Route::get('details', [BusinessDetailsController::class, 'index'])->name('details'); // View business details
            Route::get('details/edit', [BusinessDetailsController::class, 'edit'])->name('details.edit'); // Edit business details
            Route::patch('details/update', [BusinessDetailsController::class, 'update'])->name('details.update'); // Update business details

            Route::resource('services', BusinessServiceController::class); // Manage business services

            Route::get('bookings', [BusinessBookingController::class, 'index'])->name('bookings'); // List of all bookings
            Route::get('bookings/{booking}', [BusinessBookingController::class, 'show'])->name('bookings.show'); // Booking details
            Route::patch('bookings/{booking}/accept', [BusinessBookingController::class, 'accept'])->name('bookings.accept'); // Accept booking
            Route::patch('bookings/{booking}/deny', [BusinessBookingController::class, 'deny'])->name('bookings.deny'); // Deny booking
            Route::patch('bookings/bulk', [BusinessBookingController::class, 'bulkUpdate'])->name('bookings.bulk'); // Bulk update bookings

            // Discount Codes for Business
            Route::resource('discounts', BusinessDiscountController::class)->except(['show']);
        });

        // Routes for businesses with incomplete setup
        Route::middleware('business.setup.incomplete')->group(function () {
            Route::get('setup/step-one', [BusinessSetupController::class, 'stepOne'])->name('setup.stepOne'); // Setup step 1
            Route::post('setup/step-one', [BusinessSetupController::class, 'storeStepOne'])->name('setup.storeStepOne'); // Save setup step 1
            Route::get('setup/step-two', [BusinessSetupController::class, 'stepTwo'])->name('setup.stepTwo'); // Setup step 2
            Route::post('setup/step-two', [BusinessSetupController::class, 'storeStepTwo'])->name('setup.storeStepTwo'); // Save setup step 2
        });
    });

    // Client-specific routes
    roleBasedRoutes('client', User::ROLE_CLIENT, 'client', function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Client dashboard
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile

        Route::get('services', [ClientServiceController::class, 'index'])->name('services'); // View services
        Route::get('services/{service}', [ClientServiceController::class, 'show'])->name('services.show'); // View specific service
        Route::post('services/{service}/reviews', [ReviewController::class, 'store'])->name('reviews.store'); // Submit a review

        Route::get('services/{service}/available-slots', [BookingController::class, 'availableSlots'])->name('services.available-slots'); // Check available slots

        Route::post('services/{service}/bookings', [BookingController::class, 'store'])->name('bookings.store'); // Book a service

        Route::get('bookings', [ClientBookingController::class, 'index'])->name('bookings'); // View bookings
        Route::get('bookings/{booking}', [ClientBookingController::class, 'show'])->name('bookings.show'); // View specific booking
        Route::delete('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    });

});

// Include authentication routes
require __DIR__ . '/auth.php';
