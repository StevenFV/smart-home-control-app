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
        return [
            'ieee_address' => $this->ieeeAddressFaker(),
            'friendly_name' => $this->friendlyNameFaker(),
            'energy' => $this->faker->randomFloat(2, 0, 100),
            'keypad_lockout' => $this->faker->randomElement(['unlock', 'lock1', 'lock2']),
            'linkquality' => $this->faker->numberBetween(0, 100),
            'local_temperature' => $this->faker->randomFloat(1, 18, 28),
            'occupied_heating_setpoint' => $this->faker->randomFloat(1, 18, 25),
            'pi_heating_demand' => $this->faker->numberBetween(0, 100),
            'power' => $this->faker->numberBetween(0, 100),
            'running_state' => $this->faker->randomElement(['idle', 'heat']),
            'system_mode' => 'heat',
            'temperature_display_mode' => $this->faker->randomElement(['celsius', 'fahrenheit']),
        ];
    }
}
