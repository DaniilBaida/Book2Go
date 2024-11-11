<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Dynamically generate view path based on role
        $rolePrefix = $this->getRolePrefix();

        return view("$rolePrefix.profile.edit", [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Dynamically determine redirect route
        $rolePrefix = $this->getRolePrefix();

        return Redirect::route("$rolePrefix.profile.edit")->with('status', 'profile-updated');
    }

    /**
     * Get the role prefix for views and routes based on the user's role.
     */
    private function getRolePrefix(): string
    {
        return match (Auth::user()->role_id) {
            1 => 'admin',
            2 => 'business',
            3 => 'client',
            default => 'profile', // Fallback if role doesn't match
        };
    }
}
