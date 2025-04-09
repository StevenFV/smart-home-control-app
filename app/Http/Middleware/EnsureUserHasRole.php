<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to ensure the authenticated user has at least one of the specified roles.
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user() || ! $request->user()->hasAnyRole(($roles))) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
