<?php

use App\Enums\Role;
use Illuminate\Support\Facades\Hash;
use Tests\Enums\Authentication;

const USER_PASSWORD = '/user/password';

test('password can be updated', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $this->put(USER_PASSWORD, [
        'current_password' => Authentication::TEST_PASSWORD->value,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('current password must be correct', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $response = $this->put(USER_PASSWORD, [
        'current_password' => Authentication::WRONG_PASSWORD->value,
        'password' => Authentication::TEST_PASSWORD->value,
        'password_confirmation' => Authentication::TEST_PASSWORD->value,
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(Authentication::TEST_PASSWORD->value, $user->fresh()->password))->toBeTrue();
});

test('new passwords must match', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $response = $this->put(USER_PASSWORD, [
        'current_password' => Authentication::TEST_PASSWORD->value,
        'password' => 'new-password',
        'password_confirmation' => Authentication::WRONG_PASSWORD->value,
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(Authentication::TEST_PASSWORD->value, $user->fresh()->password))->toBeTrue();
});
