<?php

use App\Enums\Role;
use Tests\Enums\Authentication;

test('other browser sessions can be logged out', function () {
    $this->actingAs($this->createUser(Role::User));

    $response = $this->delete('/user/other-browser-sessions', [
        'password' => Authentication::TEST_PASSWORD->value,
    ]);

    $response->assertSessionHasNoErrors();
});
