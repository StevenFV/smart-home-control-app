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

    protected ?float $occupiedHeatingSetpoint = null;

    /**
     * Define the model's default state.
     *
     * @throws RandomException
     */
    public function definition(): array
    {
        $localTemperature = $this->faker->randomFloat(1, 18, 28);
        $occupiedHeatingSetpoint = $this->occupiedHeatingSetpoint ?? $this->faker->randomElement(range(18.0, 25.0, 0.5));
        $energy = $localTemperature === $occupiedHeatingSetpoint ?
            0.12 :
            $this->faker->randomFloat(2, 10, 100);
        $piHeatingDemand = $localTemperature >= $occupiedHeatingSetpoint
            ? 0
            : (int) min(100, round(($occupiedHeatingSetpoint - $localTemperature) * 100));

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
            'temperature_display_mode' => 'celsius',
        ];
    }

    /**
     * Set the occupied heating setpoint.
     */
    public function withOccupiedHeatingSetpoint(float $occupiedHeatingSetpoint): self
    {
        $modelInstance = $this->newInstance();
        $modelInstance->occupiedHeatingSetpoint = $occupiedHeatingSetpoint;


        return $modelInstance;
    }
}
