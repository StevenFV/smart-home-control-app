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
        $state = $this->faker->randomElement(['on', 'off']);

        return [
            'ieee_address' => $this->ieeeAddressFaker(),
            'friendly_name' => $this->friendlyName ?: $this->friendlyNameFaker(),
            'brightness' => $state === 'off' ? 0 : $this->faker->numberBetween(10, 100),
            'energy' => $state === 'off' ? 0.12 : $this->faker->randomFloat(2, 10, 100),
            'linkquality' => $this->faker->numberBetween(0, 200),
            'power' => $state === 'off' ? 0.00 : $this->faker->randomFloat(2, 10, 100),
            'state' => $state,
        ];
    }
}
