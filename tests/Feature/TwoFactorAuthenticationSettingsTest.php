<?php

use App\Enums\Role;
use Laravel\Fortify\Features;

const TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED = 'Two factor authentication is not enabled.';
const USER_TWO_FACTOR_AUTHENTICATION = '/user/two-factor-authentication';
const USER_TWO_FACTOR_RECOVERY_CODES = '/user/two-factor-recovery-codes';

test('two factor authentication can be enabled', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(USER_TWO_FACTOR_AUTHENTICATION);

    expect($user->fresh()->two_factor_secret)->not
        ->toBeNull()
        ->and($user->fresh()->recoveryCodes())->toHaveCount(8);
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED);

test('recovery codes can be regenerated', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(USER_TWO_FACTOR_AUTHENTICATION);
    $this->post(USER_TWO_FACTOR_RECOVERY_CODES);

    $user = $user->fresh();

    $this->post(USER_TWO_FACTOR_RECOVERY_CODES);

    expect($user->recoveryCodes())
        ->toHaveCount(8)
        ->and(array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()))->toHaveCount(8);
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED);

test('two factor authentication can be disabled', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(USER_TWO_FACTOR_AUTHENTICATION);

    $this->assertNotNull($user->fresh()->two_factor_secret);

    $this->delete(USER_TWO_FACTOR_AUTHENTICATION);

    expect($user->fresh()->two_factor_secret)->toBeNull();
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED);
