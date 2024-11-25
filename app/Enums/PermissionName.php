<?php

namespace App\Enums;

enum PermissionName: string
{
    /*
     * When this enum is modified, the enum "resources/js/Enums/PermissionName.js"
     * have to be changed too for consistency with Vue.js.
    */

    case ViewLighting = 'view lighting';
    case ControlLighting = 'control lighting';
    case ControlDevices = 'control devices';
    case Create = 'create';
    case Read = 'read';
    case Update = 'update';
    case Delete = 'delete';
    case ManageDevices = 'manage devices';
    case ManageUsers = 'manage users';
    case ViewLogs = 'view logs';
}
