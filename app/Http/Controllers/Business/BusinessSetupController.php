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
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $business = Auth::user()->business;
        $business->name = $request->name;


        if ($request->hasFile('logo_path')) {
            $path = $request->file('logo_path')->store('logos', 'public');
            $business->logo_path= '/storage/' . $path;
        }

        $business->save();

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
            'city' => 'required|string|max:255',
        ]);



        $business = Auth::user()->business;

        if (empty($business->name)) {
            return redirect()->route('business.setup.stepOne')->withErrors('Please complete Step One first.');
        }

        $business->city = $request->input('city');
        $business->setup_complete = true;
        $business->save();

        return redirect()->route('business.dashboard')->with('success', 'Business setup completed successfully.');
    }

    /**
     * Exibe a terceira etapa do assistente de configuração.
     */
    public function stepThree(): View
    {
        return view('business.setup.step-three');
    }

    /**
     * Processa a terceira etapa do assistente de configuração.
     */
    public function storeStepThree(Request $request)
    {
        $request->validate([
            'service_category' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->service_category = $request->service_category;
        $user->save();

        return redirect()->route('business.setup.confirm');
    }


}
