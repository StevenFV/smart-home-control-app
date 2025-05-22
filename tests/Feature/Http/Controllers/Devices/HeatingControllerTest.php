<?php

use App\Models\Devices\Heating;

test('returns correct heating data', function () {
    $heating = Heating::factory()->create();

    expect($heating->ieee_address)->toBeValidIeeeAddress()
        ->and($heating->friendly_name)->toBeValidfriendlyName()
        ->and($heating->energy)->toBeFloat()
        ->and($heating->keypad_lockout)->toBeIn(['unlock', 'lock1', 'lock2'])
        ->and($heating->linkquality)->toBeInt()
        ->and($heating->local_temperature)->toBeFloat()
        ->and($heating->occupied_heating_setpoint)->toBeFloat()
        ->and($heating->pi_heating_demand)->toBeBetween(0, 100)->toBeInt()
        ->and($heating->power)->toBeBetween(0, 100)->toBeInt()
        ->and($heating->running_state)->toBeIn(['idle', 'heat'])
        ->and($heating->system_mode)->toBe('heat')
        ->and($heating->temperature_display_mode)->toBeIn(['celsius', 'fahrenheit'])
        ->and($heating->updated_at)->toBeInstanceOf(DateTime::class)
        ->and($heating->created_at)->toBeInstanceOf(DateTime::class)
        ->and($heating->id)->toBeInt();
});
