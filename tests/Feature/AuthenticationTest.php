<?php

use Tests\Enums\TestMessage;

const LOGIN = '/login';

test('login screen can be rendered', function () {
    $response = $this->get(LOGIN);

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = $this->createUserWithUserRole();

    $response = $this->post(LOGIN, [
        'email' => $user->email,
        'password' => TestMessage::TEST_PASSWORD->value,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users cannot authenticate with invalid password', function () {
    $user = $this->createUserWithUserRole();

    $this->post(LOGIN, [
        'email' => $user->email,
        'password' => TestMessage::WRONG_PASSWORD->value,
    ]);

    $this->assertGuest();
});
