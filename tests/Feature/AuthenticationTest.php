<?php

const LOGIN = '/login';

test('login screen can be rendered', function () {
    $response = $this->get(LOGIN);

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = createUserWithUserRole();

    $response = $this->post(LOGIN, [
        'email' => $user->email,
        'password' => TEST_PASSWORD,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users cannot authenticate with invalid password', function () {
    $user = createUserWithUserRole();

    $this->post(LOGIN, [
        'email' => $user->email,
        'password' => WRONG_PASSWORD,
    ]);

    $this->assertGuest();
});
