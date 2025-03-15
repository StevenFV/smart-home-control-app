<?php

use App\Models\User;
use Laravel\Jetstream\Features;

const USER_CONFIRM_PASSWORD = '/user/confirm-password';

test('confirm password screen can be rendered', function () {
    $user = Features::hasTeamFeatures()
                    ? User::factory()->withPersonalTeam()->create()
                    : createUserWithUserRole();

    $response = $this->actingAs($user)->get(USER_CONFIRM_PASSWORD);

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = createUserWithUserRole();

    $response = $this->actingAs($user)->post(USER_CONFIRM_PASSWORD, [
        'password' => TEST_PASSWORD,
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = createUserWithUserRole();

    $response = $this->actingAs($user)->post(USER_CONFIRM_PASSWORD, [
        'password' => WRONG_PASSWORD,
    ]);

    $response->assertSessionHasErrors();
});
