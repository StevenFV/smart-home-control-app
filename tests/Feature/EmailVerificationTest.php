<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;
use Tests\Enums\TestMessage;

test('email verification screen can be rendered', function () {
    $user = $this->createUserWithUserRole();
    $user->email_verified_at = null;
    $user->save();

    $response = $this->actingAs($user)->get('/email/verify');

    $response->assertStatus(200);
})->skip(function () {
    return ! Features::enabled(Features::emailVerification());
}, TestMessage::EMAIL_VERIFICATION_NOT_ENABLED->value);

test('email can be verified', function () {
    Event::fake();

    $user = $this->createUserWithUserRole();
    $user->email_verified_at = null;
    $user->save();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)],
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false) . '?verified=1');
})->skip(function () {
    return ! Features::enabled(Features::emailVerification());
}, TestMessage::EMAIL_VERIFICATION_NOT_ENABLED->value);

test('email can not verified with invalid hash', function () {
    $user = $this->createUserWithUserRole();
    $user->email_verified_at = null;
    $user->save();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1(TestMessage::WRONG_EMAIL->value)],
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
})->skip(function () {
    return ! Features::enabled(Features::emailVerification());
}, TestMessage::EMAIL_VERIFICATION_NOT_ENABLED->value);
