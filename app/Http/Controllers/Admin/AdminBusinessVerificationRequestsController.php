<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class AdminBusinessVerificationRequestsController extends Controller
{
    public function index()
    {
        // Fetch pending business verification requests
        $businessRequests = Business::where('verification_status', 'pending')->get();
        return view('admin.business-verification-requests.index', compact('businessRequests'));
    }

    public function approve(Business $business)
    {
        $business->update(['verification_status' => 'approved']);
        return redirect()->route('business-verification-requests.index')->with('success', 'Business verified successfully.');
    }

    public function reject(Business $business)
    {
        $business->update(['verification_status' => 'rejected']);
        return redirect()->route('business-verification-requests.index')->with('error', 'Business verification rejected.');
    }
}
