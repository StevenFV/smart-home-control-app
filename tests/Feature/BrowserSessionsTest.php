<?php

use Tests\Enums\TestMessage;

test('other browser sessions can be logged out', function () {
    $this->actingAs($this->createUserWithUserRole());

    $response = $this->delete('/user/other-browser-sessions', [
        'password' => TestMessage::TEST_PASSWORD->value,
    ]);

    $response->assertSessionHasNoErrors();
});
