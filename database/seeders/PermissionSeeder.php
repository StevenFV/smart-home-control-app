<?php

namespace Database\Seeders;

use App\Enums\Permission as PermissionEnums;
use App\Enums\Role as RoleEnums;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions using the enum
        foreach (PermissionEnums::cases() as $permission) {
            Permission::create([
                'name' => $permission->name(),
                'identifier' => $permission->value,
                'description' => $permission->description(),
            ]);
        }

        // Assign permissions to roles
        $adminRole = Role::where(RoleEnums::Identifier->value, RoleEnums::Admin->value)->first();
        $userRole = Role::where(RoleEnums::Identifier->value, RoleEnums::User->value)->first();
        $guestRole = Role::where(RoleEnums::Identifier->value, RoleEnums::Guest->value)->first();

        // Assign all permissions to admin
        $adminRole->permissions()->attach(Permission::all());

        // Assign limited permissions to user
        $userRole->permissions()->attach(
            Permission::whereIn('identifier', [
                PermissionEnums::ViewDevices->value,
                PermissionEnums::ControlDevices->value,
            ])->get(),
        );

        // Assign minimal permissions to guest
        $guestRole->permissions()->attach(
            Permission::where('identifier', PermissionEnums::ViewDevices->value)->get(),
        );
    }
}
