<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessProfile;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class BusinessSetupController extends Controller
{
    public function stepOne(): View
    {
        return view('business.setup.step-one');
    }

    public function storeStepOne(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $user = Auth::user();
    
        $businessProfile = BusinessProfile::firstOrNew(['user_id' => $user->id]);
        $businessProfile->user_id = $user->id;
        $businessProfile->company_name = $request->company_name;
    
        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('logos', 'public');
            $businessProfile->company_logo = '/storage/' . $path;
        }
    
        $businessProfile->save();
    
        return redirect()->route('business.setup.stepTwo');
    }

    public function stepTwo(): View
    {
        return view('business.setup.step-two');
    }

    public function storeStepTwo(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'operating_hours' => 'required|string|max:255',
        ]);

        $businessProfile = BusinessProfile::firstOrNew(['user_id' => Auth::id()]);
        $businessProfile->location = $request->input('location');
        $businessProfile->operating_hours = $request->input('operating_hours');
        $businessProfile->save();

        return redirect()->route('business.setup.stepThree');
    }

    public function stepThree(): View
    {
        $services = Service::all();
        return view('business.setup.step-three', compact('services'));
    }

    public function storeStepThree(Request $request)
    {
        $request->validate([
            'service_category' => 'required|string|max:255',
        ]);

        $businessProfile = BusinessProfile::where('user_id', Auth::id())->firstOrFail();
        $businessProfile->service_category = $request->service_category;
        $businessProfile->save();

        return redirect()->route('business.dashboard')->with('success', 'Business setup completed successfully.');
    }

    public function confirm(): View
    {
        $user = Auth::user();
        return view('business.setup.confirm', compact('user'));
    }

    public function finish(Request $request)
    {
        $user = Auth::user();
        $user->setup_complete = true;
        $user->save();

        return redirect()->route('business.dashboard');
    }
}
