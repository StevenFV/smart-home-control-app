<?php

namespace Database\Factories\Devices;

use App\Models\Devices\Lighting;
use Database\Factories\Traits\DeviceFactoryTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends Factory<Lighting>
 */
class LightingFactory extends Factory
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
            'brightness' => $this->faker->numberBetween(0, 100),
            'energy' => $this->faker->randomFloat(2, 0, 100),
            'linkquality' => $this->faker->numberBetween(0, 100),
            'power' => $this->faker->randomFloat(2, 0, 100),
            'state' => $this->faker->randomElement(['on', 'off']),
        ];
    }
}
