<?php

use Laravel\Jetstream\Features;

test('user accounts can be deleted', function () {
    $this->actingAs($user = createUserWithUserRole());

    $this->delete('/user', [
        'password' => TEST_PASSWORD,
    ]);

    expect($user->fresh())->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = createUserWithUserRole());

    $this->delete('/user', [
        'password' => WRONG_PASSWORD,
    ]);

    expect($user->fresh())->not->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');
