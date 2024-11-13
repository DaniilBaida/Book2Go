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
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the input
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_business' => ['required', 'boolean'], // Validate as a boolean
        ]);

        // Determine if the account type is Business based on the dropdown value
        $isBusiness = $request->boolean('is_business');

        // Create the user with the correct role_id based on account type
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $isBusiness ? 2 : 1,
        ]);

        // Fire the registered event
        event(new Registered($user));

        // Log in the user
        Auth::login($user);

        // Redirect based on the account type
        if ($isBusiness) {
            // Ensure the business record is created, then redirect to step one
            $user->business()->create();
            return redirect()->route('business.setup.stepOne');
        }

        // Redirect to the client dashboard for non-business users
        return redirect()->route('client.dashboard');
    }


}
