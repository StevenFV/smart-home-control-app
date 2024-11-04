<?php

use App\Models\User;
use Database\Factories\UserFactory;

const LOGIN = '/login';

test('login screen can be rendered', function () {
    $response = $this->get(LOGIN);

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(LOGIN, [
        'email' => $user->email,
        'password' => UserFactory::getUserPassword(),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(LOGIN, [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
