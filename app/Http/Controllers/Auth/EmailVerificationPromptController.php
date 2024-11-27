<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();
        $roleDashboardRoute = strtolower($user->getRoleName($user->role_id)) . '.dashboard';
        return $user->hasVerifiedEmail()
                    ? redirect()->intended(route($roleDashboardRoute, absolute: false))
                    : view('auth.verify-email');
    }
}
