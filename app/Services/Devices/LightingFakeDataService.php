<?php

namespace App\Services\Devices;

use App\Http\Requests\Devices\DeviceRequest;
use App\Models\Devices\Lighting;

class LightingFakeDataService
{
    public static function toggleLightingState(DeviceRequest $request): void
    {
        $friendlyName = $request['friendlyName'];
        $currentState = Lighting::where('friendly_name', $friendlyName)->value('state');
        $newState = $currentState === 'ON' ? 'OFF' : 'ON';
        $data = Lighting::factory()
            ->forFriendlyName($friendlyName)
            ->withState($newState)
            ->make()
            ->toArray();

        /**
         * Remove attributes to only update necessary data.
         */
        unset($data['friendly_name'], $data['brightness'], $data['linkquality']);

        Lighting::updateOrCreate(
            ['friendly_name' => $friendlyName],
            $data,
        );
    }
}
