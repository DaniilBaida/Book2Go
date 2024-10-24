<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $fileName = $uuid . '.png'; // Filename with UUID and extension
        $directory = 'avatars'; // Directory to store avatars within 'storage/app/public/'
        $storagePath = storage_path('app/public/' . $directory); // Full path to the storage directory

        // Ensure the directory exists
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory, 0755, true);
        }

        // Create the avatar image
        $image = $avatar->create($request->name)->getImageObject();

        // Save the image directly to the file system
        $image->save($storagePath . '/' . $fileName, 90, 'png'); // 90 is the quality, 'png' is the format

        $filePath = $directory . '/' . $fileName; // Path to store in the database (e.g., 'avatars/UUID.png')
        $user->avatar_path = '/storage/' . $filePath;
        $user->save(); // Save the updated user object to the database



        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
