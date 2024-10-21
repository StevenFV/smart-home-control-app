<?php

use App\Models\User;
use Database\Factories\UserFactory;

test('other browser sessions can be logged out', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->delete('/user/other-browser-sessions', [
        'password' => UserFactory::getUserPassword(),
    ]);

    $response->assertSessionHasNoErrors();
});
