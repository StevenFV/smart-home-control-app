<?php

namespace Database\Seeders;

use App\Enums\DeviceModelClassName;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
        ]);

        foreach (DeviceModelClassName::cases() as $deviceModelClassName) {
            $this->callWith(StoreDevicesIdentificationSeeder::class, [
                'deviceModelClassName' => $deviceModelClassName,
            ]);
        }
    }
}
