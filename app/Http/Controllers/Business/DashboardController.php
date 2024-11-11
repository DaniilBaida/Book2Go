<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $businessProfile = BusinessProfile::where('user_id', Auth::id())->first();
        
        return view('business.dashboard', compact('businessProfile'));
    }
}

