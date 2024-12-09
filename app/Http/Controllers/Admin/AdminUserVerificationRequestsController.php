<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserVerificationRequestsController extends Controller
{
    public function index(Request $request)
    {
        // Start the query to get only unverified users
        $query = User::query()->where('is_verified', false);

        // Apply search functionality for name and email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        // Apply sorting logic
        if ($request->has('sort') && $request->has('direction')) {
            $sortField = $request->input('sort');
            $direction = $request->input('direction');

            if ($sortField === 'user') {
                // Sort by the user's name
                $query->whereHas('user')->orderBy('users.name', $direction);
            } else {
                // Sort by fields in the Review model
                $query->orderBy($sortField, $direction);
            }
        }

        // Paginate the results
        $verificationRequests = $query->paginate(10);

        // Return the view with verification requests
        return view('admin.verification-requests.index', compact('verificationRequests'));
    }

    // Approve Verification

    public function approve(User $user)
    {
        $user->is_verified = 1;
        $user->save();
        return back()->with('success', 'User verified successfully.');
    }

    // Reject Verification
    public function reject(User $user)
    {
        $user->is_verified = 2;
        $user->save();
        return back()->with('success', 'User verification request rejected.');
    }
}
