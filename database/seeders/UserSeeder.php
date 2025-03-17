<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            $name = config('auth.' . $role->identifier . '.name');
            $email = config('auth.' . $role->identifier . '.email');
            $password = config('auth.' . $role->identifier . '.passwords');

            if (User::where('email', $email)->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role_id' => $role->id,
            ]);
        }
    }
}
