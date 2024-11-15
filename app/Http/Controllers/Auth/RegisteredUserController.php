<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View The view displaying the registration form.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request The incoming registration request.
     * @return RedirectResponse The response redirecting to the appropriate route after registration.
     *
     * @throws ValidationException If validation fails.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'], // First name is required and should be a string
            'last_name' => ['required', 'string', 'max:255'],  // Last name is required and should be a string
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'], // Email must be unique
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // Password must be confirmed and meet the default password rules
            'is_business' => ['required', 'boolean'], // Boolean to indicate if the user is registering as a business
        ]);

        // Determine if the account type is Business based on the form input
        $isBusiness = $request->boolean('is_business');

        // Create the user with the appropriate role_id based on the account type
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password before saving
            'role_id' => $isBusiness ? 2 : 1, // Set the role_id based on whether the account is a business or not
        ]);

        // Fire the Registered event, which could be used for sending a welcome email or logging
        event(new Registered($user));

        // Log the user in after registration
        Auth::login($user);

        // Redirect the user based on their account type
        if ($isBusiness) {
            // For business accounts, ensure the business record is created
            $user->business()->create();
            return redirect()->route('business.setup.stepOne'); // Redirect to business setup step one
        }

        // For non-business accounts, redirect to the client dashboard
        return redirect()->route('client.dashboard');
    }
}
