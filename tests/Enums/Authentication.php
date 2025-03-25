<?php

namespace Tests\Enums;

enum Authentication: string
{
    case PASSWORD_RESET = 'password-reset';
    case TEST_PASSWORD = 'test-password';
    case WRONG_EMAIL = 'wrong-email';
    case WRONG_PASSWORD = 'wrong-password';
}
