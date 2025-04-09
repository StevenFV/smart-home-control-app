<?php

use App\Enums\Role;
use App\Models\User;
use Laravel\Jetstream\Features;
use Tests\Enums\Message;

test('users can leave teams', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = $this->createUser(Role::User),
        ['role' => 'admin'],
    );

    $this->actingAs($otherUser);

    $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $otherUser->id);

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
})->skip(function () {
    return ! Features::hasTeamFeatures();
}, Message::TEAM_SUPPORT_IS_NOT_ENABLED->value);

test('team owners cant leave their own team', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $response = $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $user->id);

    $response->assertSessionHasErrorsIn('removeTeamMember', ['team']);

    expect($user->currentTeam->fresh())->not->toBeNull();
})->skip(function () {
    return ! Features::hasTeamFeatures();
}, Message::TEAM_SUPPORT_IS_NOT_ENABLED->value);
