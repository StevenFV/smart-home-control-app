<?php

namespace Database\Factories\Devices;

use App\Models\Devices\Lighting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Random\RandomException;

/**
 * @extends <Lighting>
 */
class LightingFactory extends Factory
{
    /**
     * Define the model's default state.
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

    /**
     * @throws RandomException
     */
    private function ieeeAddressFaker(): string
    {
        $hexPart = bin2hex(random_bytes(8));

        return '0x' . $hexPart;
    }

    private function friendlyNameFaker(): string
    {
        /**
         * @throws RandomException
         */
        $randomWord = fn() => Str::lower(Str::random(random_int(3, 10)));

        return implode('/', [
            $randomWord(),
            $randomWord(),
            $randomWord(),
            $randomWord() . '_' . $randomWord(),
            $randomWord() . '_' . $randomWord(),
        ]);
    }
}
