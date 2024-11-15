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
     * Exibe a primeira etapa do assistente de configuração.
     */
    public function stepOne(): View
    {
        return view('business.setup.step-one');
    }

    /**
     * Processa a primeira etapa do assistente de configuração.
     */
    public function storeStepOne(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $request->session()->put('business_step_one', $request->only([
            'name', 'email', 'phone_number', 'address', 'city', 'postal_code', 'country'
        ]));

        return redirect()->route('business.setup.stepTwo');
    }

    /**
     * Exibe a segunda etapa do assistente de configuração.
     */
    public function stepTwo(): View
    {
        return view('business.setup.step-two');
    }

    /**
     * Processa a segunda etapa do assistente de configuração.
     */
    public function storeStepTwo(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:1000',
            'logo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        // Retrieve Step 1 data from session
        $stepOneData = $request->session()->get('business_step_one');

        if (!$stepOneData) {
            return redirect()->route('business.setup.stepOne')->withErrors('Please complete Step One first.');
        }

        // Retrieve or create a new business for the authenticated user
        $business = Auth::user()->business;
        $business->fill($stepOneData);

        // Save additional data from Step 2
        if ($request->hasFile('logo_path')) {
            $path = $request->file('logo_path')->store('logos', 'public');
            $business->logo_path = 'storage/' . $path;
        }

        $business->description = $request->input('description');
        $business->setup_complete = true;

        $business->save();

        // Clear the session data for Step 1
        $request->session()->forget('business_step_one');

        return redirect()->route('business.dashboard')->with('success', 'Business setup completed successfully.');
    }   
    
}
