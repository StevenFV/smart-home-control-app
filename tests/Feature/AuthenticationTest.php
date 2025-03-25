<?php

use App\Enums\Role;
use Tests\Enums\Authentication;

const LOGIN = '/login';

test('login screen can be rendered', function () {
    $response = $this->get(LOGIN);

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = $this->createUser(Role::User);

    $response = $this->post(LOGIN, [
        'email' => $user->email,
        'password' => Authentication::TEST_PASSWORD->value,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users cannot authenticate with invalid password', function () {
    $user = $this->createUser(Role::User);

    $this->post(LOGIN, [
        'email' => $user->email,
        'password' => Authentication::WRONG_PASSWORD->value,
    ]);

    $this->assertGuest();
});
