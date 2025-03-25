<?php

namespace App\Enums;

enum Web: string
{
    case AdminOrUserOrGuest = 'role:admin,user,guest';
}
