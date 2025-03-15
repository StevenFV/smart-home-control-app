<?php

use App\Models\User;
use Laravel\Jetstream\Features;

test('teams can be created', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/teams', [
        'name' => 'Test Team',
    ]);

    expect($user->fresh()->ownedTeams)->toHaveCount(2);
    expect($user->fresh()->ownedTeams()->latest('id')->first()->name)->toEqual('Test Team');
})->skip(function () {
    return !Features::hasTeamFeatures();
}, TEAM_SUPPORT_IS_NOT_ENABLED);
