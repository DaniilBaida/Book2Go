<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\View\View The view displaying the list of users.
     */
    public function index()
    {
        $users = User::with('role')->paginate(5);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View The view for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in the database.
     *
     * @param Request $request The incoming request with the user data.
     * @return RedirectResponse Redirect to the user list with a success message.
     */
    public function store(Request $request)
    {
        // Validate the incoming user data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1, // Default role for the new user
        ]);

        event(new Registered($user)); // Fire the registered event

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param User $user The user to display.
     * @return \Illuminate\View\View The view displaying the user's details.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user The user to edit.
     * @return \Illuminate\View\View The view for editing the user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified user in the database.
     *
     * @param Request $request The incoming request with the updated data.
     * @param User $user The user to update.
     * @return RedirectResponse Redirect back with a success message.
     */
    public function update(Request $request, User $user)
    {
        // Validate the updated user data
        $userData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.max' => 'The name may not be greater than :max characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters long.',
        ]);

        // Update the user information
        $user->first_name = $userData['first_name'];
        $user->last_name = $userData['last_name'];
        $user->email = $userData['email'];
        if (isset($userData['password'])) {
            $user->password = Hash::make($userData['password']);
        }

        $user->save(); // Save the updated user

        return redirect()->back()->with('success', 'User information updated successfully.');
    }

    /**
     * Update the avatar for the specified user.
     *
     * @param Request $request The incoming request with the avatar file.
     * @param int $id The user ID to update.
     * @return RedirectResponse Redirect back with a success message.
     */
    public function updateUserAvatar(Request $request, $id)
    {
        // Validate the incoming avatar file
        $request->validate([
            'avatar_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::findOrFail($id);

        // Remove the old avatar if it exists
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        // Store the new avatar
        $path = $request->file('avatar_path')->store('avatars', 'public');
        $user->avatar_path = '/storage/' . $path;
        $user->save();

        return redirect()->back()->with('status', 'Avatar updated successfully.');
    }
}
