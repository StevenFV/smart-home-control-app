<?php

use App\Enums\Role;

test('profile information can be updated', function () {
    $this->actingAs($user = $this->createUser(Role::User));

    $this->put('/user/profile-information', [
        'name' => 'Test Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh())
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com');
});
