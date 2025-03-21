<?php

namespace Tests\Enums;

enum TestMessage: string
{
    case API_SUPPORT_IS_NOT_ENABLED = 'API support is not enabled.';
    case EMAIL_VERIFICATION_NOT_ENABLED = 'Email verification not enabled.';
    case PASSWORD_RESET = 'password-reset';
    case REGISTRATION_SUPPORT_IS_ENABLED = 'Registration support is enabled.';
    case REGISTRATION_SUPPORT_IS_NOT_ENABLED = 'Registration support is not enabled.';
    case TEAM_INVITATIONS_NOT_ENABLED = 'Team invitations not enabled.';
    case TEST_PASSWORD = 'test-password';
    case TEAM_SUPPORT_IS_NOT_ENABLED = 'Team support is not enabled.';
    case TO_BE_VALID_IEEE_ADDRESS = 'Expected "%s" to be a valid IEEE address in format "0x1234567812345678"';
    case WRONG_EMAIL = 'wrong-email';
    case WRONG_PASSWORD = 'wrong-password';
}
