<?php

namespace App\Enums;

enum Role: string
{
    /*
     * When this enum is modified, the enum "resources/js/Enums/PermissionRole.js"
     * have to be change too for consistance with Vue.js.
    */

    case Admin = 'admin';
    case AdminOrUserOrGuest = 'role:admin,user,guest';
    case Guest = 'guest';
    case User = 'user';
}
