<?php

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\Enums\TestMessage;

const FORGOT_PASSWORD = '/forgot-password';
const PASSWORD_UPDATES_ARE_NOT_ENABLED = 'Password updates are not enabled.';

test('reset password link screen can be rendered', function () {
    $response = $this->get(FORGOT_PASSWORD);

    $response->assertStatus(200);
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, PASSWORD_UPDATES_ARE_NOT_ENABLED);

test('reset password link can be requested', function () {
    Notification::fake();

    $user = $this->createUserWithUserRole();

    $this->post(FORGOT_PASSWORD, [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class);
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, PASSWORD_UPDATES_ARE_NOT_ENABLED);

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = $this->createUserWithUserRole();

    $this->post(FORGOT_PASSWORD, [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function (object $notification) {
        $response = $this->get('/reset-password/' . $notification->token);

        $response->assertStatus(200);

        return true;
    });
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, PASSWORD_UPDATES_ARE_NOT_ENABLED);

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = $this->createUserWithUserRole();

    $this->post(FORGOT_PASSWORD, [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
        $response = $this->post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => TestMessage::PASSWORD_RESET->value,
            'password_confirmation' => TestMessage::PASSWORD_RESET->value,
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
})->skip(function () {
    return ! Features::enabled(Features::resetPasswords());
}, PASSWORD_UPDATES_ARE_NOT_ENABLED);
