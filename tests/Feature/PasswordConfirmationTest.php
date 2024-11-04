<?php

use App\Models\User;
use Database\Factories\UserFactory;
use Laravel\Jetstream\Features;

const USER_CONFIRM_PASSWORD = '/user/confirm-password';
test('confirm password screen can be rendered', function () {
    $user = Features::hasTeamFeatures()
                    ? User::factory()->withPersonalTeam()->create()
                    : User::factory()->create();

    $response = $this->actingAs($user)->get(USER_CONFIRM_PASSWORD);

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(USER_CONFIRM_PASSWORD, [
        'password' => UserFactory::getUserPassword(),
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(USER_CONFIRM_PASSWORD, [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
