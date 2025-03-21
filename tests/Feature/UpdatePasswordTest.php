<?php

use Illuminate\Support\Facades\Hash;
use Tests\Enums\TestMessage;

const USER_PASSWORD = '/user/password';

test('password can be updated', function () {
    $this->actingAs($user = $this->createUserWithUserRole());

    $this->put(USER_PASSWORD, [
        'current_password' => TestMessage::TEST_PASSWORD->value,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('current password must be correct', function () {
    $this->actingAs($user = $this->createUserWithUserRole());

    $response = $this->put(USER_PASSWORD, [
        'current_password' => TestMessage::WRONG_PASSWORD->value,
        'password' => TestMessage::TEST_PASSWORD->value,
        'password_confirmation' => TestMessage::TEST_PASSWORD->value,
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(TestMessage::TEST_PASSWORD->value, $user->fresh()->password))->toBeTrue();
});

test('new passwords must match', function () {
    $this->actingAs($user = $this->createUserWithUserRole());

    $response = $this->put(USER_PASSWORD, [
        'current_password' => TestMessage::TEST_PASSWORD->value,
        'password' => 'new-password',
        'password_confirmation' => TestMessage::WRONG_PASSWORD->value,
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(TestMessage::TEST_PASSWORD->value, $user->fresh()->password))->toBeTrue();
});
