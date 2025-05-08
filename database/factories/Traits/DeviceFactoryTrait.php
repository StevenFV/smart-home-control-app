<?php

namespace Database\Factories\Traits;

use Illuminate\Support\Str;
use Random\RandomException;

trait DeviceFactoryTrait
{
    /**
     * Generate a random IEEE address.
     *
     * @throws RandomException
     */
    private function ieeeAddressFaker(): string
    {
        $hexPart = bin2hex(random_bytes(8));

        return '0x' . $hexPart;
    }

    /**
     * Generate a random friendly name with a standardized format.
     *
     * @throws RandomException
     */
    private function friendlyNameFaker(): string
    {
        $randomWord = fn () => Str::lower(Str::random(random_int(3, 10)));

        return implode('/', [
            $randomWord(),
            $randomWord(),
            $randomWord(),
            $randomWord() . '_' . $randomWord(),
            $randomWord() . '_' . $randomWord(),
        ]);
    }
}
