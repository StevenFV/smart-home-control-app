<?php

use App\Models\User;
use Laravel\Jetstream\Features;

test('api tokens can be created', function () {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = createUserWithUserRole());
    }

    $this->post('/user/api-tokens', [
        'name' => 'Test Token',
        'permissions' => [
            'read',
            'update',
        ],
    ]);

    expect($user->fresh()->tokens)
        ->toHaveCount(1)
        ->and($user->fresh()->tokens->first())
        ->name
        ->toEqual('Test Token')
        ->can('read')->toBeTrue()
        ->can('delete')->toBeFalse();
})->skip(function () {
    return ! Features::hasApiFeatures();
}, API_SUPPORT_IS_NOT_ENABLED);
