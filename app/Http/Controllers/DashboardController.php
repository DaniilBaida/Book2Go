<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on the user's role.
     *
     * @return View The view corresponding to the user's role.
     */
    public function index(): View
    {
        $user = Auth::user();

        return match ($user->role_id) {
            1 => $this->clientDashboard(),
            2 => $this->businessDashboard($user),
            3 => $this->adminDashboard(),
            default => view('auth.login'),
        };
    }

    /**
     * Show the client dashboard.
     *
     * @return View
     */
    private function clientDashboard(): View
    {
        return view('client.dashboard');
    }

    /**
     * Show the business dashboard.
     *
     * @param $user
     * @return View
     */
    private function businessDashboard($user): View
    {
        $business = $user->business()->with('services.bookings')->first();

        // Calculate total services
        $totalServices = $business->services->count();

        // Define date ranges for current and previous months
        $currentMonthRange = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
        $previousMonthRange = [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()];

        // Count services created in the current and previous month
        $currentMonthServices = $business->services()
            ->whereBetween('created_at', $currentMonthRange)
            ->count();

        $previousMonthServices = $business->services()
            ->whereBetween('created_at', $previousMonthRange)
            ->count();

        // Calculate percentage change in services
        $percentageChangeInServices = $this->calculatePercentageChange($previousMonthServices, $currentMonthServices);

        // Calculate total bookings
        $currentMonthBookings = $business->services->sum(fn($service) =>
        $service->bookings->whereBetween('created_at', $currentMonthRange)->count()
        );

        $previousMonthBookings = $business->services->sum(fn($service) =>
        $service->bookings->whereBetween('created_at', $previousMonthRange)->count()
        );

        // Calculate percentage change in bookings
        $percentageChangeInBookings = $this->calculatePercentageChange($previousMonthBookings, $currentMonthBookings);

        // Calculate profile completion percentage
        $profileCompletion = $this->calculateProfileCompletion($business);

        return view('business.dashboard', compact(
            'totalServices',
            'percentageChangeInServices',
            'currentMonthBookings',
            'percentageChangeInBookings',
            'profileCompletion'
        ));
    }

    /**
     * Show the admin dashboard.
     *
     * @return View
     */
    private function adminDashboard(): View
    {
        return view('admin.dashboard');
    }

    private function calculatePercentageChange(int $previous, int $current): float
    {
        return $previous > 0
            ? (($current - $previous) / $previous) * 100
            : ($current > 0 ? 100 : 0);
    }

    /**
     * Calculate the profile completion percentage for a business.
     *
     * @param $business
     * @return int
     */
    private function calculateProfileCompletion($business): int
    {
        $totalScore = 0;

        // Mandatory fields (50%)
        if ($business->name) $totalScore += 10;
        if ($business->email) $totalScore += 10;
        if ($business->phone_number) $totalScore += 10;
        if ($business->street_address) $totalScore += 10;
        if ($business->country) $totalScore += 5;
        if ($business->city) $totalScore += 5;
        if ($business->postal_code) $totalScore +=10;

        // Optional fields (25% each)
        if ($business->description) $totalScore += 25;
        if ($business->logo_path) $totalScore += 25;

        // Calculate the percentage
        return min(100, $totalScore); // Ensure it does not exceed 100%
    }


    /**
     * Count bookings within a date range for all services.
     *
     * @param $business
     * @param array $dateRange
     * @return int
     */
    private function countBookings($business, array $dateRange): int
    {
        return $business->services->sum(fn($service) =>
        $service->bookings->whereBetween('created_at', $dateRange)->count()
        );
    }
}
