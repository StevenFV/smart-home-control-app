<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Guest = 'guest';
    case Name = 'name';
    case User = 'user';
    case Identifier = 'identifier';
}
