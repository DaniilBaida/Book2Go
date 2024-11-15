<?php

namespace App\Http\Controllers;

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
        // Check the user's role and return the appropriate dashboard view
        switch (Auth::user()->role_id) {
            case 1:
                return view('client.dashboard'); // Client dashboard
            case 2:
                return view('business.dashboard'); // Business dashboard (Ensure this view exists)
            case 3:
                return view('admin.dashboard'); // Admin dashboard (Ensure this view exists)
            default:
                return view('auth.login'); // Redirect to login if no valid role is found
        }
    }
}
