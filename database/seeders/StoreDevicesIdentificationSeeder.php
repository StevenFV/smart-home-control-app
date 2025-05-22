<?php

namespace Database\Seeders;

use App\Enums\DeviceModelClassName;
use App\Models\Devices\Heating;
use App\Models\Devices\Lighting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class StoreDevicesIdentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') !== 'local') {
            foreach (DeviceModelClassName::cases() as $deviceModelClassName) {
                Artisan::call('device:store-identification', [
                    'deviceModelClassName' => $deviceModelClassName->value,
                ]);
            }
        } else {
            $lightingLangFile = require base_path('lang/fr/lighting.php');
            $heatingLangFile = require base_path('lang/fr/heating.php');
            $lightingFriendlyNames = array_keys($lightingLangFile['topic_title']);
            $heatingFriendlyNames = array_keys($heatingLangFile['topic_title']);

            foreach ($lightingFriendlyNames as $lightingFriendlyName) {
                Lighting::factory()->forFriendlyName($lightingFriendlyName)->create();
            }
            foreach ($heatingFriendlyNames as $heatingFriendlyName) {
                Heating::factory()->forFriendlyName($heatingFriendlyName)->create();
            }
        }
    }
}
