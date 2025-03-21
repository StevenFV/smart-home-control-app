<?php

use App\Models\User;
use Laravel\Jetstream\Features;
use Tests\Enums\TestMessage;

test('team names can be updated', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->put('/teams/' . $user->currentTeam->id, [
        'name' => 'Test Team',
    ]);

    expect($user->fresh()->ownedTeams)->toHaveCount(1);
    expect($user->currentTeam->fresh()->name)->toEqual('Test Team');
})->skip(function () {
    return !Features::hasTeamFeatures();
}, TestMessage::TEAM_SUPPORT_IS_NOT_ENABLED->value);
