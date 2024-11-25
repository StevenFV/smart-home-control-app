<?php

namespace App\Enums;

enum PermissionRole: string
{
    /*
     * When this enum is modified, the enum "resources/js/Enums/PermissionRole.js"
     * have to be change too for consistance with Vue.js.
    */

    case Role = 'role';
    case Admin = 'admin';
    case User = 'user';
}
