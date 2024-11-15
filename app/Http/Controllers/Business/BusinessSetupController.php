<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class BusinessSetupController extends Controller
{
    /**
     * Display the first step of the business setup wizard.
     *
     * @return View The view for the first step of business setup.
     */
    public function stepOne(): View
    {
        return view('business.setup.step-one');
    }

    /**
     * Process the first step of the business setup wizard.
     *
     * @param Request $request The incoming request with business details.
     * @return \Illuminate\Http\RedirectResponse Redirect to the next setup step.
     */
    public function storeStepOne(Request $request)
    {
        // Validate the required fields for business setup step one
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        // Store the validated data for Step 1 in the session
        $request->session()->put('business_step_one', $request->only([
            'name', 'email', 'phone_number', 'address', 'city', 'postal_code', 'country'
        ]));

        // Redirect to the second step of the business setup
        return redirect()->route('business.setup.stepTwo');
    }

    /**
     * Display the second step of the business setup wizard.
     *
     * @return View The view for the second step of business setup.
     */
    public function stepTwo(): View
    {
        return view('business.setup.step-two');
    }

    /**
     * Process the second step of the business setup wizard.
     *
     * @param Request $request The incoming request with business logo and description.
     * @return \Illuminate\Http\RedirectResponse Redirect to the business dashboard upon completion.
     */
    public function storeStepTwo(Request $request)
    {
        // Validate the fields for business setup step two
        $request->validate([
            'description' => 'nullable|string|max:1000',
            'logo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // Logo file validation
        ]);

        // Retrieve Step 1 data from the session
        $stepOneData = $request->session()->get('business_step_one');

        // Check if Step 1 was completed before proceeding
        if (!$stepOneData) {
            return redirect()->route('business.setup.stepOne')->withErrors('Please complete Step One first.');
        }

        // Retrieve or create a new business for the authenticated user
        $business = Auth::user()->business;
        $business->fill($stepOneData);

        // Save additional data from Step 2
        if ($request->hasFile('logo_path')) {
            // Store the logo image file in the 'logos' directory
            $path = $request->file('logo_path')->store('logos', 'public');
            $business->logo_path = 'storage/' . $path;
        }

        // Save description and mark setup as complete
        $business->description = $request->input('description');
        $business->setup_complete = true;

        // Save the business model with the new data
        $business->save();

        // Clear the session data for Step 1
        $request->session()->forget('business_step_one');

        // Redirect to the business dashboard with a success message
        return redirect()->route('business.dashboard')->with('success', 'Business setup completed successfully.');
    }
}
