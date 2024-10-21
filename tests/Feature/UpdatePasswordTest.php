<?php

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $this->actingAs($user = User::factory()->create());

    $this->put('/user/password', [
        'current_password' => UserFactory::getUserPassword(),
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('current password must be correct', function () {
    $this->actingAs($user = User::factory()->create());

    $response = $this->put('/user/password', [
        'current_password' => 'wrong-password',
        'password' => UserFactory::getUserPassword(),
        'password_confirmation' => UserFactory::getUserPassword(),
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(UserFactory::getUserPassword(), $user->fresh()->password))->toBeTrue();
});

test('new passwords must match', function () {
    $this->actingAs($user = User::factory()->create());

    $response = $this->put('/user/password', [
        'current_password' => UserFactory::getUserPassword(),
        'password' => 'new-password',
        'password_confirmation' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check(UserFactory::getUserPassword(), $user->fresh()->password))->toBeTrue();
});
