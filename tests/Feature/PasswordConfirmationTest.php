<?php

use App\Enums\Role;
use App\Models\User;
use Laravel\Jetstream\Features;
use Tests\Enums\Authentication;

const USER_CONFIRM_PASSWORD = '/user/confirm-password';

test('confirm password screen can be rendered', function () {
    $user = Features::hasTeamFeatures()
                    ? User::factory()->withPersonalTeam()->create()
                    : $this->createUser(Role::User);

    $response = $this->actingAs($user)->get(USER_CONFIRM_PASSWORD);

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = $this->createUser(Role::User);

    $response = $this->actingAs($user)->post(USER_CONFIRM_PASSWORD, [
        'password' => Authentication::TEST_PASSWORD->value,
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = $this->createUser(Role::User);

    $response = $this->actingAs($user)->post(USER_CONFIRM_PASSWORD, [
        'password' => Authentication::WRONG_PASSWORD->value,
    ]);

    $response->assertSessionHasErrors();
});
