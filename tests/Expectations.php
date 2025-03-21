<?php

use Tests\Enums\TestMessage;

expect()->extend('toBeValidIeeeAddress', function () {
    expect($this->value)->toBeString();

    $zigbeePattern = '/^0x[0-9a-f]{16}$/i';
    $isValidFormat = preg_match($zigbeePattern, $this->value) === 1;

    expect($isValidFormat)->toBeTrue(sprintf(TestMessage::TO_BE_VALID_IEEE_ADDRESS->value, $this->value));

    return $this;
});
