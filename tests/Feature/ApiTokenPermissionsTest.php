<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Tests\Enums\Message;

test('api token permissions can be updated', function () {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = $this->createUser(Role::User));
    }

    $token = $user->tokens()->create([
        'name' => 'Test Token',
        'token' => Str::random(40),
        'abilities' => ['create', 'read'],
    ]);

    $this->put('/user/api-tokens/' . $token->id, [
        'name' => $token->name,
        'permissions' => [
            'delete',
            'missing-permission',
        ],
    ]);

    expect($user->fresh()->tokens->first())
        ->can('delete')->toBeTrue()
        ->can('read')->toBeFalse()
        ->can('missing-permission')->toBeFalse();
})->skip(function () {
    return ! Features::hasApiFeatures();
}, Message::API_SUPPORT_IS_NOT_ENABLED->value);
