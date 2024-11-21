<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class BusinessController extends Controller
{
    /**
     * Display a listing of the businesses.
     *
     * @return \Illuminate\View\View The view displaying the list of businesses.
     */
    public function index()
    {
        $businesses = Business::paginate(5); // Assuming `category` is the relationship
        return view('admin.business.index', compact('businesses'));
    }

    /**
     * Show the form for creating a new business.
     *
     * @return \Illuminate\View\View The view for creating a new business.
     */
    public function create()
    {
        return view('admin.business.create');
    }

    public function updateLogo(Request $request, Business $business)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Delete the old logo if it exists
        if ($business->logo_path) {
            Storage::disk('public')->delete($business->logo_path);
        }

        // Store the new logo
        $path = $request->file('logo')->store('logos', 'public');
        $business->logo_path = '/storage/' . $path;
        $business->save();

        return redirect()->back()->with('status', 'Logo updated successfully.');
    }

    public function updateGeneralInfo(Request $request, Business $business)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $business->update($validatedData);

        return redirect()->route('admin.businesses.edit', $business->id)
            ->with('success', 'Business information updated successfully.');
    }


    public function updateContact(Request $request, Business $business)
    {
        $validatedData = $request->validate([
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:2',
            'city' => 'required|string|max:100',
        ]);

        $business->update($validatedData);

        return redirect()->route('admin.businesses.edit', $business->id)
            ->with('success', 'Contact details updated successfully.');
    }


    /**
     * Store a newly created business in the database.
     *
     * @param Request $request The incoming request with the business data.
     * @return RedirectResponse Redirect to the business list with a success message.
     */
    public function store(Request $request)
    {
        // Validate the incoming business data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:businesses'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'location' => ['nullable', 'string', 'max:255'],
            'operating_hours' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'], // Assuming you have a categories table
        ]);

        // Create the business
        $business = Business::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
            'operating_hours' => $request->operating_hours,
            'category_id' => $request->category_id,
        ]);

        event(new Registered($business)); // Fire the registered event

        return redirect()->route('admin.businesses.index')->with('success', 'Business created successfully.');
    }

    /**
     * Display the specified business.
     *
     * @param Business $business The business to display.
     * @return \Illuminate\View\View The view displaying the business's details.
     */
    public function show(Business $business)
    {
        return view('admin.business.show', compact('business'));
    }

    /**
     * Show the form for editing the specified business.
     *
     * @param Business $business The business to edit.
     * @return \Illuminate\View\View The view for editing the business.
     */
    public function edit(Business $business)
    {
        return view('admin.business.edit', compact('business'));
    }

    /**
     * Update the specified business in the database.
     *
     * @param Request $request The incoming request with the updated data.
     * @param Business $business The business to update.
     * @return RedirectResponse Redirect back with a success message.
     */
    public function update(Request $request, Business $business)
    {
        // Validate the updated business data
        $businessData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('businesses')->ignore($business->id)],
            'password' => ['nullable', 'string', 'confirmed', Password::defaults()],
            'location' => ['nullable', 'string', 'max:255'],
            'operating_hours' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        // Update the business information
        $business->name = $businessData['name'];
        $business->email = $businessData['email'];
        if (isset($businessData['password'])) {
            $business->password = Hash::make($businessData['password']);
        }
        $business->location = $businessData['location'];
        $business->operating_hours = $businessData['operating_hours'];
        $business->category_id = $businessData['category_id'];

        $business->save(); // Save the updated business

        return redirect()->back()->with('success', 'Business information updated successfully.');
    }

    /**
     * Update the avatar for the specified business.
     *
     * @param Request $request The incoming request with the avatar file.
     * @param int $id The business ID to update.
     * @return RedirectResponse Redirect back with a success message.
     */
    public function updateBusinessAvatar(Request $request, $id)
    {
        // Validate the incoming avatar file
        $request->validate([
            'avatar_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $business = Business::findOrFail($id);

        // Remove the old avatar if it exists
        if ($business->avatar_path) {
            Storage::disk('public')->delete($business->avatar_path);
        }

        // Store the new avatar
        $path = $request->file('avatar_path')->store('avatars', 'public');
        $business->avatar_path = '/storage/' . $path;
        $business->save();

        return redirect()->back()->with('status', 'Avatar updated successfully.');
    }

    /**
     * Remove the specified business from the database.
     *
     * @param Business $business The business to delete.
     * @return RedirectResponse Redirect back with a success message.
     */
    public function destroy(Business $business)
    {
        $business->delete();

        return redirect()->route('admin.businesses.index')->with('success', 'Business deleted successfully.');
    }

    public function showUserProfile($id)
    {
        // Busca o usuário e calcula a média de reviews
        $user = User::with('reviews')->findOrFail($id);
        $averageRating = $user->reviews->avg('rating') ?? 0; // Define 0 se não houver reviews
        $totalReviews = $user->reviews->count();

        return view('business.bookings.partials.business-show-user', compact('user', 'averageRating', 'totalReviews'));
    }
}