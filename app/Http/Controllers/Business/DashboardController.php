<?php

namespace App\Http\Controllers\Business;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('business.dashboard');
    }
}
