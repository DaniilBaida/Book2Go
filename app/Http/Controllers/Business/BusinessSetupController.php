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
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $user->company_name = $request->input('company_name');

        if ($request->hasFile('logo')) {
            // Armazena o logo da empresa
            $path = $request->file('logo')->store('logos', 'public');
            $user->company_logo = '/storage/' . $path;
        }

        $user->save();

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
            'location' => 'required|string|max:255',
            'operating_hours' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->location = $request->input('location');
        $user->operating_hours = $request->input('operating_hours');
        $user->save();

        // Redireciona para o dashboard do Business ao invés de um terceiro passo
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

    /**
     * Exibe a página de confirmação final.
     */
    public function confirm(): View
    {
        $user = Auth::user();
        return view('business.setup.confirm', compact('user'));
    }

    /**
     * Finaliza o assistente de configuração após a confirmação.
     */
    public function finish(Request $request)
    {
        // Aqui você pode adicionar uma flag de "configuração concluída" no usuário.
        $user = Auth::user();
        $user->setup_complete = true;
        $user->save();

        return redirect()->route('business.dashboard');
    }
}
