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
use Laravolt\Avatar\Avatar;
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $avatar = new Avatar(); // Initialize the Avatar object
        $uuid = (string) Str::uuid(); // Generate a unique UUID for the file name
        $fileName = $uuid . '.png'; // Set the avatar file name with the UUID and '.png' extension
        $filePath = 'avatars/' . $fileName; // Define the relative path for storing the avatar


        // Check if the avatars directory exists, and if not, create it with proper permissions
        $storageDir = storage_path('app/public/avatars');
        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $avatar->create($request->name)->save($storageDir . '/' . $fileName); // Create and save the avatar image
        $user->logo_path = $filePath; // Update the user's logo_path with the avatar file path
        $user->save(); // Save the updated user object to the database

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
