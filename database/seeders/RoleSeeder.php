<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnums;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([RoleEnums::Name->value => RoleEnums::Admin->name, RoleEnums::Identifier->value => RoleEnums::Admin->value]);
        Role::create([RoleEnums::Name->value => RoleEnums::User->name, RoleEnums::Identifier->value => RoleEnums::User->value]);
        Role::create([RoleEnums::Name->value => RoleEnums::Guest->name, RoleEnums::Identifier->value => RoleEnums::Guest->value]);
    }
}
