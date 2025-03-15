<?php

use App\Models\Team;
use App\Models\User;
use Laravel\Jetstream\Features;

test('teams can be deleted', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->ownedTeams()->save($team = Team::factory()->make([
        'personal_team' => false,
    ]));

    $team->users()->attach(
        $otherUser = createUserWithUserRole(),
        ['role' => 'test-role'],
    );

    $this->delete('/teams/' . $team->id);

    expect($team->fresh())->toBeNull();
    expect($otherUser->fresh()->teams)->toHaveCount(0);
})->skip(function () {
    return !Features::hasTeamFeatures();
}, TEAM_SUPPORT_IS_NOT_ENABLED);

test('personal teams cant be deleted', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->delete('/teams/' . $user->currentTeam->id);

    expect($user->currentTeam->fresh())->not->toBeNull();
})->skip(function () {
    return !Features::hasTeamFeatures();
}, TEAM_SUPPORT_IS_NOT_ENABLED);
