<?php

namespace App\Services\Devices;

use App\Http\Requests\Devices\DeviceRequest;
use App\Models\Devices\Heating;

class HeatingFakeDataService
{
    public static function setOccupiedHeatingSetpoint(DeviceRequest $request): void
    {
        $friendlyName = $request['friendlyName'];
        $occupiedHeatingSetpoint = $request['occupiedHeatingSetpoint'];
        $data = Heating::factory()
            ->forFriendlyName($friendlyName)
            ->withOccupiedHeatingSetpoint($occupiedHeatingSetpoint)
            ->make()
            ->toArray();

        /**
         * Remove attributes to only update necessary data.
         */
        unset(
            $data['friendly_name'],
            $data['keypad_lockout'],
            $data['linkquality'],
            $data['local_temperature'],
            $data['system_mode'],
            $data['temperature_display_mode'],
        );

        Heating::updateOrCreate(
            ['friendly_name' => $friendlyName],
            $data,
        );
    }
}
