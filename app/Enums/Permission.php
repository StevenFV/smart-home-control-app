<?php

namespace App\Enums;

enum Permission: string
{
    /*
     * When this enum is modified, the enum "resources/js/Enums/PermissionName.js"
     * have to be changed too for consistency with Vue.js.
    */

    case get = 'get';
    case set = 'set';
}
