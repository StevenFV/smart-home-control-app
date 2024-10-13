<?php

namespace App\Services;

use App\Models\User;

class RoleChecker
{
    /**
     * Check if the user has any of the given roles.
     */
    public function userHasAnyRole(User $user, array $roles): bool
    {
        return collect($roles)->contains(fn($role) => $user->hasRole($role));
    }
}
