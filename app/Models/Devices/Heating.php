<?php

namespace App\Models\Devices;

use Database\Factories\Devices\HeatingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heating extends Model
{
    /** @use HasFactory<HeatingFactory> */
    use HasFactory;

    protected $table = 'devices.heats';

    protected $fillable = [
        'ieee_address',
        'friendly_name',
        'energy',
        'keypad_lockout',
        'linkquality',
        'local_temperature',
        'occupied_heating_setpoint',
        'pi_heating_demand',
        'power',
        'running_state',
        'system_mode',
        'temperature_display_mode',
    ];
}
