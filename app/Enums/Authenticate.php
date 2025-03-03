<?php

namespace App\Enums;

enum Authenticate: string
{
    case AuthSanctum = 'auth:sanctum';
    case JetstreamAuthSession = 'jetstream.auth_session';
    case Verified = 'verified';
}
