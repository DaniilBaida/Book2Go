<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBusinessSetupIncomplete
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the authenticated user has completed the business setup.
     * If the setup is complete, it redirects the user to the business dashboard with a message.
     *
     * @param Request $request The incoming request instance.
     * @param Closure(Request): (Response) $next The next middleware or request handler.
     *
     * @return Response The response from the next middleware or controller.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has a business and if the business setup is complete
        if ($user && $user->business && $user->business->setup_complete) {
            // Redirect to the business dashboard if setup is complete
            return redirect()->route('business.dashboard')->with('info', 'You have already completed the setup.');
        }

        // Proceed with the request if the setup is not complete
        return $next($request);
    }
}
