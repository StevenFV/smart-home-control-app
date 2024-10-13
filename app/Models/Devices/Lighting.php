<?php

namespace App\Models\Devices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lighting extends Model
{
    use HasFactory;

    protected $table = 'devices.lights';

    protected $fillable = ['ieee_address', 'friendly_name', 'brightness', 'energy', 'linkquality', 'power', 'state'];

    public function toArrayWithoutIeeeAddress(): array
    {
        $attributes = $this->toArray();
        unset($attributes['ieee_address']);

        return $attributes;
    }
}
