<?php

use App\Enums\Role;
use Laravel\Jetstream\Features;
use Tests\Enums\Authentication;

test('user accounts can be deleted', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $this->delete('/user', [
        'password' => Authentication::TEST_PASSWORD->value,
    ]);

    expect($user->fresh())->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $this->delete('/user', [
        'password' => Authentication::WRONG_PASSWORD->value,
    ]);

    expect($user->fresh())->not->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');
