<?php

namespace App\Http\Controllers\Client;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('client.dashboard');
    }
}
