<?php

use App\Models\Devices\Heating;
use Carbon\Carbon;

test('creates heating model successfully', function () {
    $heating = Heating::factory()->create();

    $this->assertDatabaseHas('devices.heats', [
        'ieee_address' => $heating->ieee_address,
        'friendly_name' => $heating->friendly_name,
        'energy' => $heating->energy,
        'keypad_lockout' => $heating->keypad_lockout,
        'linkquality' => $heating->linkquality,
        'local_temperature' => $heating->local_temperature,
        'occupied_heating_setpoint' => $heating->occupied_heating_setpoint,
        'pi_heating_demand' => $heating->pi_heating_demand,
        'power' => $heating->power,
        'running_state' => $heating->running_state,
        'system_mode' => $heating->system_mode,
        'temperature_display_mode' => $heating->temperature_display_mode,
        'created_at' => $heating->created_at,
        'updated_at' => $heating->updated_at,
    ]);
});

test('updates heating model successfully', function () {
    $heating = Heating::factory()->create();

    $originalTime = Carbon::now();
    Carbon::setTestNow($originalTime->addSecond());

    $newOccupiedHeatingSetpoint = $heating->occupied_heating_setpoint + 0.5;
    $originalUpdatedAt = $heating->updated_at;

    $heating->update([
        'occupied_heating_setpoint' => $newOccupiedHeatingSetpoint,
    ]);

    $this->assertTrue($heating->updated_at > $originalUpdatedAt, "Error: updated_at isn't updated");

    $this->assertDatabaseHas('devices.heats', [
        'ieee_address' => $heating->ieee_address,
        'occupied_heating_setpoint' => $newOccupiedHeatingSetpoint,
    ]);
});

test('deletes heating model successfully', function () {
    $heating = Heating::factory()->create();

    $heating->delete();

    $this->assertDatabaseMissing('devices.heats', ['id' => $heating->id]);
});
