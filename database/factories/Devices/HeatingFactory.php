<?php

namespace Database\Factories\Devices;

use App\Models\Devices\Heating;
use Database\Factories\Traits\DeviceFactoryTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends Factory<Heating>
 */
class HeatingFactory extends Factory
{
    use DeviceFactoryTrait;

    /**
     * Define the model's default state.
     *
     * @throws RandomException
     */
    public function definition(): array
    {
        $localTemperature = $this->faker->randomFloat(1, 18, 28);
        $occupiedHeatingSetpoint = $this->faker->randomFloat(1, 18, 25);
        $energy = $localTemperature === $occupiedHeatingSetpoint ?
            0.12 :
            $this->faker->randomFloat(2, 10, 100);
        $piHeatingDemand = $localTemperature >= $occupiedHeatingSetpoint
            ? 0
            : min(100, round(($occupiedHeatingSetpoint - $localTemperature) * 100));

        return [
            'ieee_address' => $this->ieeeAddressFaker(),
            'friendly_name' => $this->friendlyName ?: $this->friendlyNameFaker(),
            'energy' => $energy,
            'keypad_lockout' => $this->faker->randomElement(['unlock', 'lock1', 'lock2']),
            'linkquality' => $this->faker->numberBetween(0, 200),
            'local_temperature' => $localTemperature,
            'occupied_heating_setpoint' => $occupiedHeatingSetpoint,
            'pi_heating_demand' => $piHeatingDemand,
            'power' => $piHeatingDemand,
            'running_state' => $piHeatingDemand < 10 ? 'idle' : 'heat',
            'system_mode' => 'heat',
            'temperature_display_mode' => $this->faker->randomElement(['celsius', 'fahrenheit']),
        ];
    }
}
