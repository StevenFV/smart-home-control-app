<?php

use App\Models\User;
use Laravel\Jetstream\Features;
use Tests\Enums\Message;

test('teams can be created', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/teams', [
        'name' => 'Test Team',
    ]);

    expect($user->fresh()->ownedTeams)->toHaveCount(2);
    expect($user->fresh()->ownedTeams()->latest('id')->first()->name)->toEqual('Test Team');
})->skip(function () {
    return !Features::hasTeamFeatures();
}, Message::TEAM_SUPPORT_IS_NOT_ENABLED->value);
