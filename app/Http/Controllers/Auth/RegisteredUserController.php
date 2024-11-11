<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Verifica se o usuário selecionou a opção para criar uma conta business
        $isBusiness = $request->boolean('is_business');

        // Cria o usuário com role_id dependendo do tipo de conta
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $isBusiness ? 2 : 1, // 2 para Business, 1 para usuário comum
        ]);

        // Dispara o evento de registro
        event(new Registered($user));

        // Autentica o usuário automaticamente após o registro
        Auth::login($user);

        // Redireciona o usuário para a etapa inicial de configuração caso seja business
        if ($isBusiness) {
            return redirect()->route('business.setup.stepOne');
        }

        // Redireciona para o dashboard do cliente se não for business
        return redirect()->route('client.dashboard');
    }
}
