<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        if (!$user || !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if ($request->route()->named('verification.notice') && $user->hasVerifiedEmail()) {
            $roleDashboardRoute = strtolower($user->getRoleName($user->role_id)) . '.dashboard';
            return redirect()->route($roleDashboardRoute);

        }
        return $next($request);
    }
}
