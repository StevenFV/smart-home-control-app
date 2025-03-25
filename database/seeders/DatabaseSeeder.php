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

        $this->callWith(StoreDevicesIdentificationSeeder::class, [
            'deviceModelClassName' => DeviceModelClassName::Lighting->value,
        ]);
    }
}
