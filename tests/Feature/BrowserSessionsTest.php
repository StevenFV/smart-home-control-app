<?php

test('other browser sessions can be logged out', function () {
    $this->actingAs(createUserWithUserRole());

    $response = $this->delete('/user/other-browser-sessions', [
        'password' => TEST_PASSWORD,
    ]);

    $response->assertSessionHasNoErrors();
});
