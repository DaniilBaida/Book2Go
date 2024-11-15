<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        switch (Auth::user()->role_id) {
            case 1:
                return view('client.dashboard');
            case 2:
                return view('business.dashboard'); // Ensure this view exists
            case 3:
                return view('admin.dashboard'); // Ensure this view exists
            default:
                return view('auth.login');
        }
    }
}
