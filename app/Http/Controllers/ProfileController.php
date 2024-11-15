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
     *
     * @param Request $request The incoming HTTP request.
     * @return View The view for editing the user's profile.
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
     *
     * @param ProfileUpdateRequest $request The validated request data.
     * @return RedirectResponse The response after the update is successful.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Fill the user model with validated data
        $request->user()->fill($request->validated());

        // If the email has changed, reset the email verification timestamp
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Save the updated user information
        $request->user()->save();

        // Dynamically determine the redirect route
        $rolePrefix = $this->getRolePrefix();

        // Redirect to the profile edit page with a success message
        return Redirect::route("$rolePrefix.profile.edit")->with('status', 'profile-updated');
    }

    /**
     * Get the role prefix for views and routes based on the user's role.
     *
     * @return string The role-based prefix for routes and views.
     */
    private function getRolePrefix(): string
    {
        return match (Auth::user()->role_id) {
            1 => 'client',
            2 => 'business',
            3 => 'admin',
            default => 'profile', // Fallback if role doesn't match
        };
    }
}
