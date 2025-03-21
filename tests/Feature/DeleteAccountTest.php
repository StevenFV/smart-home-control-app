<?php

use Laravel\Jetstream\Features;
use Tests\Enums\TestMessage;

test('user accounts can be deleted', function () {
    $this->actingAs($user = $this->createUserWithUserRole());

    $this->delete('/user', [
        'password' => TestMessage::TEST_PASSWORD->value,
    ]);

    expect($user->fresh())->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = $this->createUserWithUserRole());

    $this->delete('/user', [
        'password' => TestMessage::WRONG_PASSWORD->value,
    ]);

    expect($user->fresh())->not->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');
