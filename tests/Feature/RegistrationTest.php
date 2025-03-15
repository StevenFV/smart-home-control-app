<?php

use App\Models\User;
use Laravel\Fortify\Features as FortifyFeatures;
use Laravel\Jetstream\Features as JetstreamFeatures;
use Laravel\Jetstream\Jetstream;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
})->skip(function () {
    return !FortifyFeatures::enabled(FortifyFeatures::registration());
}, 'Registration support is not enabled.');

test('registration screen cannot be rendered if support is disabled', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
})->skip(function () {
    return FortifyFeatures::enabled(FortifyFeatures::registration());
}, REGISTRATION_SUPPORT_IS_ENABLED);

test('new user with team invitation can register', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->teamInvitations()->create([
        'email' => 'test@example.com',
        'role' => 'user',
    ]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
})->skip(function () {
    return !FortifyFeatures::enabled(FortifyFeatures::registration());
}, 'Registration support is not enabled.')->skip(function () {
    return !JetstreamFeatures::hasTeamFeatures();
}, TEAM_SUPPORT_IS_NOT_ENABLED);

test('new user without team invitation cannot register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    expect($response->exception->getMessage())->toBe('The selected email is invalid.');
})->skip(function () {
    return !FortifyFeatures::enabled(FortifyFeatures::registration());
}, REGISTRATION_SUPPORT_IS_NOT_ENABLED)->skip(function () {
    return !JetstreamFeatures::hasTeamFeatures();
}, TEAM_SUPPORT_IS_NOT_ENABLED);
