<?php

namespace Database\Seeders;

use App\Enums\DeviceModelClassName;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class StoreDevicesIdentificationSeeder extends Seeder
{
    private string $deviceModelClassName;

    public function __construct($deviceModelClassName = DeviceModelClassName::Lighting->value)
    {
        $this->deviceModelClassName = $deviceModelClassName;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('device:store-identification', [
            'deviceModelClassName' => $this->deviceModelClassName,
        ]);
    }
}
