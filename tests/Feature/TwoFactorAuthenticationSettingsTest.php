<?php

use App\Models\User;
use Laravel\Fortify\Features;

const USER_TWO_FACTOR_AUTHENTICATION = '/user/two-factor-authentication';

const TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED = 'Two factor authentication is not enabled.';
test('two factor authentication can be enabled', function () {
    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(USER_TWO_FACTOR_AUTHENTICATION);

    expect($user->fresh()->two_factor_secret)->not->toBeNull();
    expect($user->fresh()->recoveryCodes())->toHaveCount(8);
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED);

test('recovery codes can be regenerated', function () {
    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(USER_TWO_FACTOR_AUTHENTICATION);
    $this->post('/user/two-factor-recovery-codes');

    $user = $user->fresh();

    $this->post('/user/two-factor-recovery-codes');

    expect($user->recoveryCodes())->toHaveCount(8);
    expect(array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()))->toHaveCount(8);
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED);

test('two factor authentication can be disabled', function () {
    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(USER_TWO_FACTOR_AUTHENTICATION);

    $this->assertNotNull($user->fresh()->two_factor_secret);

    $this->delete(USER_TWO_FACTOR_AUTHENTICATION);

    expect($user->fresh()->two_factor_secret)->toBeNull();
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, TWO_FACTOR_AUTHENTICATION_IS_NOT_ENABLED);
