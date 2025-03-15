<?php

use Illuminate\Support\Facades\Hash;

const USER_PASSWORD = '/user/password';

test('password can be updated', function () {
    $this->actingAs($user = createUserWithUserRole());

    $this->put(USER_PASSWORD, [
        'current_password' => TEST_PASSWORD,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('current password must be correct', function () {
    $this->actingAs($user = createUserWithUserRole());

    $response = $this->put(USER_PASSWORD, [
        'current_password' => WRONG_PASSWORD,
        'password' => TEST_PASSWORD,
        'password_confirmation' => TEST_PASSWORD,
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(TEST_PASSWORD, $user->fresh()->password))->toBeTrue();
});

test('new passwords must match', function () {
    $this->actingAs($user = createUserWithUserRole());

    $response = $this->put(USER_PASSWORD, [
        'current_password' => TEST_PASSWORD,
        'password' => 'new-password',
        'password_confirmation' => WRONG_PASSWORD,
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(TEST_PASSWORD, $user->fresh()->password))->toBeTrue();
});
