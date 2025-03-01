<?php

namespace App\Policies;

use AllowDynamicProperties;
use App\Enums\Permission;

#[AllowDynamicProperties]
class LightingPolicy
{
    /**
     * Initializes the class instance and sets the authenticated user as a property.
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Determines if the current user has the required team permission to get data from lighting devices.
     */
    public function get(): bool
    {
        return $this->user->hasTeamPermission($this->user->currentTeam, Permission::get->value);
    }

    /**
     * Determines if the current user has the required team permission to set data to lighting devices.
     */
    public function set(): bool
    {
        return $this->user->hasTeamPermission($this->user->currentTeam, Permission::set->value);
    }
}
