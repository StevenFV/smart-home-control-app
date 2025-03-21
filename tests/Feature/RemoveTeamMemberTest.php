<?php

use App\Models\User;
use Laravel\Jetstream\Features;
use Tests\Enums\TestMessage;

test('team members can be removed from teams', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = $this->createUserWithUserRole(),
        ['role' => 'admin'],
    );

    $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $otherUser->id);

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
})->skip(function () {
    return !Features::hasTeamFeatures();
}, TestMessage::TEAM_SUPPORT_IS_NOT_ENABLED->value);

test('only team owner can remove team members', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = $this->createUserWithUserRole(),
        ['role' => 'admin'],
    );

    $this->actingAs($otherUser);

    $response = $this->delete('/teams/' . $user->currentTeam->id . '/members/' . $user->id);

    $response->assertStatus(403);
})->skip(function () {
    return !Features::hasTeamFeatures();
}, TestMessage::TEAM_SUPPORT_IS_NOT_ENABLED->value);
