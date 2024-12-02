<?php

use App\Http\Controllers\Admin\AdminBusinessVerificationRequestsController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminVerificationRequestsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Business\BusinessBookingController;
use App\Http\Controllers\Business\BusinessNotificationController;
use App\Http\Controllers\Business\BusinessReviewController;
use App\Http\Controllers\Business\BusinessSetupController;
use App\Http\Controllers\Business\BusinessServiceController;
use App\Http\Controllers\Business\BusinessDetailsController;
use App\Http\Controllers\Business\BusinessDiscountController;
use App\Http\Controllers\Client\ClientBookingController;
use App\Http\Controllers\Client\ClientNotificationController;
use App\Http\Controllers\Client\ClientReviewController;
use App\Http\Controllers\Client\ClientServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CityController;
use App\Models\User;
use App\Http\Controllers\Business\BusinessSettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;

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

// Authentication and email verification routes
Route::middleware('auth')->group(function () {
    // Email verification routes
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', function () {
        auth()->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->name('verification.send');
});

// Authenticated and verified routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead'); // Mark all as read
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead'); // Mark a specific notification as read


    // Admin-specific routes
    roleBasedRoutes('admin', User::ROLE_ADMIN, 'admin', function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Admin dashboard
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile

        Route::resource('services', ServiceController::class)->only(['index', 'show', 'destroy']); // Delete Service

        Route::resource('users', UserController::class); // User resource management
        Route::patch('users/{user}/update-password', [PasswordController::class, 'update'])
            ->name('users.update-password'); // Update user password
        Route::patch('users/{user}/update-avatar', [UserController::class, 'updateUserAvatar'])
            ->name('users.update-avatar'); // Update user avatar

        // Business Management Routes
        Route::resource('businesses', BusinessController::class);
        Route::patch('businesses/{business}/update-logo', [BusinessController::class, 'updateLogo'])
            ->name('businesses.update-logo');
        Route::patch('admin/businesses/{business}/update-general-info', [BusinessController::class, 'updateGeneralInfo'])
            ->name('businesses.update-general-info');
        Route::patch('businesses/{business}/update-contact', [BusinessController::class, 'updateContact'])
            ->name('businesses.update-contact');

        Route::resource('reviews', AdminReviewController::class)->only(['index', 'show']);
        Route::patch('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::patch('reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');

        Route::resource('discounts', AdminDiscountController::class)->except(['show']);

        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index'); // View notifications

        // Verification Requests
        Route::get('verification-requests', [AdminVerificationRequestsController::class, 'index'])->name('verification-requests.index');
        Route::post('verification-requests/{user}/approve', [AdminVerificationRequestsController::class, 'approve'])->name('verification-requests.approve');
        Route::post('verification-requests/{user}/reject', [AdminVerificationRequestsController::class, 'reject'])->name('verification-requests.reject');

        // Business Verification Requests
        Route::get('business-verification-requests', [AdminBusinessVerificationRequestsController::class, 'index'])->name('business-verification-requests.index');
        Route::post('business-verification-requests/{business}/approve', [AdminBusinessVerificationRequestsController::class, 'approve'])->name('business-verification-requests.approve');
        Route::post('business-verification-requests/{business}/reject', [AdminBusinessVerificationRequestsController::class, 'reject'])->name('business-verification-requests.reject');

    });

    // Business-specific routes
    roleBasedRoutes('business', User::ROLE_BUSINESS, 'business', function () {
        // Routes for businesses with complete setup
        Route::middleware('business.setup.complete')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Business dashboard
            Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile
            Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
            Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile

            // Details Route
            Route::get('details', [BusinessDetailsController::class, 'index'])->name('details'); // View business details
            Route::get('details/edit', [BusinessDetailsController::class, 'edit'])->name('details.edit'); // Edit business details
            Route::patch('details/update', [BusinessDetailsController::class, 'update'])->name('details.update'); // Update business details

            // Services Route
            Route::resource('services', BusinessServiceController::class); // Manage business services

            // Booking Routes
            Route::get('bookings', [BusinessBookingController::class, 'index'])->name('bookings'); // List of all bookings
            Route::get('bookings/{booking}', [BusinessBookingController::class, 'show'])->name('bookings.show'); // Booking details
            Route::patch('bookings/{booking}/accept', [BusinessBookingController::class, 'accept'])->name('bookings.accept'); // Accept booking
            Route::patch('bookings/{booking}/deny', [BusinessBookingController::class, 'deny'])->name('bookings.deny'); // Deny booking
            Route::post('bookings/bulk', [BusinessBookingController::class, 'bulkUpdate'])->name('bookings.bulk'); // Bulk update bookings
            Route::patch('bookings/{booking}/complete', [BusinessBookingController::class, 'complete'])->name('bookings.complete');
            Route::get('bookings/{booking}/reviews/create', [BusinessReviewController::class, 'create'])->name('reviews.create');
            Route::post('bookings/{booking}/reviews', [BusinessReviewController::class, 'store'])->name('reviews.store');

            // Discount Codes for Business Route
            Route::resource('discounts', BusinessDiscountController::class)->except(['show']);

            // Reviews Route
            Route::get('reviews', [BusinessReviewController::class, 'index'])->name('reviews.index'); // List of all reviews
            Route::patch('reviews/{review}/report', [BusinessReviewController::class, 'report'])->name('reviews.report'); // Report Reviews

            // Notifications Route
            Route::get('/notifications', [BusinessNotificationController::class, 'index'])->name('notifications.index'); // List of all notifications

            Route::get('/users/{id}', [BusinessController::class, 'showUserProfile'])->name('users.show');
            Route::get('/business/bookings/{id}/details', [BusinessBookingController::class, 'show'])->name('business.bookings.details');

            // Settings Route
            Route::get('/settings', [BusinessSettingsController::class, 'index'])->name('settings.index'); // Account Settings
            Route::patch('/settings', [BusinessSettingsController::class, 'update'])->name('settings.update'); // Save Account Settings
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

        Route::get('bookings/{booking}/reviews/create', [ClientReviewController::class, 'create'])->name('reviews.create');
        Route::post('bookings/{booking}/reviews', [ClientReviewController::class, 'store'])->name('reviews.store');
        Route::patch('reviews/{review}/report', [ClientReviewController::class, 'report'])->name('reviews.report');

        Route::get('services/{service}/available-slots', [ClientBookingController::class, 'availableSlots'])
            ->name('services.available-slots'); // Check available slots for a service

        Route::post('services/{service}/bookings', [ClientBookingController::class, 'store'])->name('bookings.store'); // Book a service

        Route::get('bookings', [ClientBookingController::class, 'index'])->name('bookings'); // View bookings
        Route::get('bookings/{booking}', [ClientBookingController::class, 'show'])->name('bookings.show');  // View specific booking
        Route::delete('bookings/{booking}/cancel', [ClientBookingController::class, 'cancel'])->name('bookings.cancel');

        Route::post('bookings/{booking}/pay', [ClientBookingController::class, 'pay'])->name('pay');

        Route::get('/notifications', [ClientNotificationController::class, 'index'])->name('notifications.index'); // View notifications
        Route::get('/payment/success/{booking}', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/cancel/{booking}', [PaymentController::class, 'cancel'])->name('payment.cancel');

        // Settings Route
        Route::get('/settings', [BusinessSettingsController::class, 'index'])->name('settings.index'); // Account Settings
        Route::patch('/settings', [BusinessSettingsController::class, 'update'])->name('settings.update'); // Save Account Settings
    });
});

// Include authentication routes
require __DIR__ . '/auth.php';
