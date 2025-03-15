<?php

namespace App\Enums;

enum Permission: string
{
    /*
     * When this enum is modified, the enum "resources/js/Enums/PermissionName.js"
     * have to be changed too for consistency with Vue.js.
    */

    case ManageDevices = 'manageDevices';
    case ControlDevices = 'controlDevices';
    case ViewDevices = 'viewDevices';

    public function name(): string
    {
        return match ($this) {
            self::ManageDevices => 'Manage Devices',
            self::ControlDevices => 'Control Devices',
            self::ViewDevices => 'View Devices',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ManageDevices => 'Add, edit, or delete devices and their settings',
            self::ControlDevices => 'Operate devices and adjust their settings without administrative access',
            self::ViewDevices => 'View device status and information without making changes',
        };
    }

    /**
     * Get all permissions as an array of [identifier => name]
     */
    public static function toArray(): array
    {
        $permissions = [];

        foreach (self::cases() as $case) {
            $permissions[$case->value] = $case->name();
        }

        return $permissions;
    }
}
