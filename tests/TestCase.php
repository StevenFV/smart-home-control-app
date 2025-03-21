<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\Enums\TestMessage;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutDeprecationHandling();
    }

    protected function createUserWithUserRole(): User
    {
        $roleSeeder = new RoleSeeder();
        $roleSeeder->run();

        $adminRole = Role::where('identifier', 'admin')->first();

        $user = new User();
        $user->name = 'Test User';
        $user->email = 'test@email.com';
        $user->email_verified_at = now();
        $user->password = Hash::make(TestMessage::TEST_PASSWORD->value);
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->remember_token = Str::random(10);
        $user->role_id = $adminRole?->id;
        $user->save();

        return $user;
    }
}
