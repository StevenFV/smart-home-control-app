<?php

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)->in('Feature', 'Unit');
uses(RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

const API_SUPPORT_IS_NOT_ENABLED = 'API support is not enabled.';
const EMAIL_VERIFICATION_NOT_ENABLED = 'Email verification not enabled.';
const PASSWORD_RESET = 'password-reset';
const REGISTRATION_SUPPORT_IS_ENABLED = 'Registration support is enabled.';
const REGISTRATION_SUPPORT_IS_NOT_ENABLED = 'Registration support is not enabled.';
const TEAM_INVITATIONS_NOT_ENABLED = 'Team invitations not enabled.';
const TEST_PASSWORD = 'test-password';
const TEAM_SUPPORT_IS_NOT_ENABLED = 'Team support is not enabled.';
const WRONG_EMAIL = 'wrong-email';
const WRONG_PASSWORD = 'wrong-password';

function createUserWithUserRole(): User
{
    $roleSeeder = new RoleSeeder();
    $roleSeeder->run();

    $adminRole = Role::where('identifier', 'admin')->first();

    $user = new User();
    $user->name = 'Test User';
    $user->email = 'test@email.com';
    $user->email_verified_at = now();
    $user->password = Hash::make(TEST_PASSWORD);
    $user->two_factor_secret = null;
    $user->two_factor_recovery_codes = null;
    $user->remember_token = Str::random(10);
    $user->role_id = $adminRole?->id;
    $user->save();

    return $user;
}
