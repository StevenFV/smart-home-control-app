<?php

namespace Database\Seeders;

use App\Models\Devices\Heating;
use App\Models\Devices\Lighting;
use Illuminate\Database\Seeder;

class StoreDevicesFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lightingLangFile = require base_path('lang/fr/lighting.php');
        $heatingLangFile = require base_path('lang/fr/heating.php');
        $lightingFriendlyNames = array_keys($lightingLangFile['topic_title']);
        $heatingFriendlyNames = array_keys($heatingLangFile['topic_title']);

        foreach ($lightingFriendlyNames as $lightingFriendlyName) {
            Lighting::updateOrCreate(
                ['friendly_name' => $lightingFriendlyName],
                Lighting::factory()->forFriendlyName($lightingFriendlyName)->make()->toArray(),
            );
        }
        foreach ($heatingFriendlyNames as $heatingFriendlyName) {
            Heating::updateOrCreate(
                ['friendly_name' => $heatingFriendlyName],
                Heating::factory()->forFriendlyName($heatingFriendlyName)->make()->toArray(),
            );
        }
    }
}
