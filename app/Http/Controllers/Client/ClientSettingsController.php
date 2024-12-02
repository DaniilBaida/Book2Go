<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;

class ClientSettingsController extends Controller
{
    public function index()
    {
        // Load the settings view
        return view('client.settings.index');
    }

    public function update(Request $request)
    {
        // Redirect back with a success message
        return redirect()->route('client.settings.index')->with('success', 'Settings updated successfully.');
    }

}
