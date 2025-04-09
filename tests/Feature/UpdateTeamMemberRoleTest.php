<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Jetstream\Features;
use Tests\Enums\Message;

test('team member roles can be updated', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = $this->createUser(Role::User),
        ['role' => 'admin'],
    );

    $this->put('/teams/' . $user->currentTeam->id . '/members/' . $otherUser->id, [
        'role' => 'user',
    ]);

    expect($otherUser->fresh()->hasTeamRole(
        $user->currentTeam->fresh(),
        'user',
    ))->toBeTrue();
})->skip(function () {
    return ! Features::hasTeamFeatures();
}, Message::TEAM_SUPPORT_IS_NOT_ENABLED->value);

test('only team owner can update team member roles', function () {
    $authorizationException = new AuthorizationException();

    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = $this->createUser(Role::User),
        ['role' => 'admin'],
    );

    $this->actingAs($otherUser);

    $this->put('/teams/' . $user->currentTeam->id . '/members/' . $otherUser->id, [
        'role' => 'user',
    ]);

    $isActionUnauthorizedMessage = $authorizationException->getMessage() === 'This action is unauthorized.';

    expect($otherUser->fresh()->hasTeamRole(
        $user->currentTeam->fresh(),
        'admin',
    ))->and($isActionUnauthorizedMessage)->toBeTrue();
})->skip(function () {
    return ! Features::hasTeamFeatures();
}, Message::TEAM_SUPPORT_IS_NOT_ENABLED->value);
