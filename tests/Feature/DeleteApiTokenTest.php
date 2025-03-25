<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Tests\Enums\Message;

test('api tokens can be deleted', function () {
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

    $this->delete('/user/api-tokens/' . $token->id);

    expect($user->fresh()->tokens)->toHaveCount(0);
})->skip(function () {
    return ! Features::hasApiFeatures();
}, Message::API_SUPPORT_IS_NOT_ENABLED->value);
