<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;

class BusinessSettingsController extends Controller
{
    public function index()
    {
        // Load the settings view
        return view('business.settings.index');
    }

    public function update(Request $request)
    {
        // Redirect back with a success message
        return redirect()->route('business.settings.index')->with('success', 'Settings updated successfully.');
    }

}
