<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class AdminUserWithTeamAndRoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new UserFactory())->withPersonalTeam()->withAdminRole()->create()->first();
    }
}
