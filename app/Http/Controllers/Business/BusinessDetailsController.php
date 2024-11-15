<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessDetailsController extends Controller
{
    // Display business details
    public function index()
    {
        // Fetch the authenticated user's business details
        $business = Auth::user()->business;

        // Return the view for displaying business details
        return view('business.details.index', compact('business'));
    }

    // Show the form for editing business details
    public function edit()
    {
        // Fetch the authenticated user's business details
        $business = Auth::user()->business;

        // Return the view for editing business details
        return view('business.details.edit', compact('business'));
    }

    // Update business details
    public function update(Request $request)
    {
        // Fetch the authenticated user's business details
        $business = Auth::user()->business;

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'logo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        // Get the data from the request, excluding 'logo_path' for now
        $data = $request->except('logo_path');

        // Handle file upload if a new logo is provided
        if ($request->hasFile('logo_path')) {
            // Delete the old logo if it exists
            if ($business->logo_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $business->logo_path));
            }
            // Store the new logo in the 'logos' directory
            $path = $request->file('logo_path')->store('logos', 'public');
            // Add the path of the new logo to the data array
            $data['logo_path'] = 'storage/' . $path;
        }

        // Update the business with the new data
        $business->update($data);

        // Redirect back to the details page with a success message
        return redirect()->route('business.details.index')->with('success', 'Business details updated successfully.');
    }
}
