<?php

namespace Database\Factories\Traits;

use Illuminate\Support\Str;
use Random\RandomException;

trait DeviceFactoryTrait
{
    /**
     * The current friendly name to use.
     */
    protected string $friendlyName = '';

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
     * Set the friendly name.
     */
    public function forFriendlyName(string $name): self
    {
        $modelInstance = $this->newInstance();
        $modelInstance->friendlyName = $name;

        return $modelInstance;
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
