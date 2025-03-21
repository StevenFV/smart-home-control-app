<?php

use App\Models\Devices\Lighting;

it('returns correct lighting data', function () {
    $lighting = Lighting::factory()->create();

    expect($lighting->ieee_address)->toBeValidIeeeAddress()
        ->and($lighting->friendly_name)->toBeString()
        ->and($lighting->brightness)->toBeInt()
        ->and($lighting->energy)->toBeFloat()
        ->and($lighting->linkquality)->toBeInt()
        ->and($lighting->power)->toBeFloat()
        ->and($lighting->state)->toBeString()
        ->and($lighting->updated_at)->toBeInstanceOf(DateTime::class)
        ->and($lighting->created_at)->toBeInstanceOf(DateTime::class)
        ->and($lighting->id)->toBeInt();
});
