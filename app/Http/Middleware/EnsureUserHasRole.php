<?php

namespace App\Http\Middleware;

use App\Services\RoleChecker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    protected RoleChecker $roleChecker;

    public function __construct(RoleChecker $roleChecker)
    {
        $this->roleChecker = $roleChecker;
    }

    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $rolesArray = explode('|', $roles);
        $user = $request->user();

        if ($this->roleChecker->userHasAnyRole($user, $rolesArray)) {
            return $next($request);
        }

        abort(403);
    }
}
