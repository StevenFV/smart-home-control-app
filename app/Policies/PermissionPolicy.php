<?php

namespace App\Policies;

use AllowDynamicProperties;
use App\Enums\Permission as PermissionEnums;

#[AllowDynamicProperties]
class PermissionPolicy
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
    public function viewDevices(): bool
    {
        return $this->user->hasPermission(PermissionEnums::ViewDevices);
    }

    /**
     * Determines if the current user has the required team permission to set data to lighting devices.
     */
    public function controlDevices(): bool
    {
        return $this->user->hasPermission(PermissionEnums::ControlDevices);
    }

    public function manageDevices()
    {
        return $this->user->hasPermission(PermissionEnums::ManageDevices);
    }
}
