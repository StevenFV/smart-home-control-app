<?php

namespace Database\Seeders;

use App\Enums\DeviceModelClassName;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class StoreDevicesIdentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (DeviceModelClassName::cases() as $deviceModelClassName) {
            Artisan::call('device:store-identification', [
                'deviceModelClassName' => $deviceModelClassName->value,
            ]);
        }
    }
}
