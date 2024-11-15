<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the authenticated user has the correct role before allowing
     * access to the requested resource.
     *
     * @param Request $request The incoming request instance.
     * @param Closure(Request): (Response) $next The next middleware or request handler.
     * @param int $roleId The required role ID that the user must have.
     *
     * @return Response The response from the next middleware or controller.
     */
    public function handle(Request $request, Closure $next, int $roleId): Response
    {
        // If the authenticated user does not have the required role, abort with a 403 Forbidden response.
        abort_if(auth()->user()->role_id !== $roleId, Response::HTTP_FORBIDDEN);

        // Continue processing the request if the user has the correct role.
        return $next($request);
    }
}
