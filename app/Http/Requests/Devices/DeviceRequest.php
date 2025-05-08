<?php

namespace App\Http\Requests\Devices;

use App\Enums\DeviceModelClassName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeviceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'friendlyName' => 'required|string|max:81',
            'set' => 'required|string|size:4|in:/set',
            'deviceModelClassName' => [
                'required',
                'string',
                Rule::in(collect(DeviceModelClassName::cases())->map->value->toArray()),
            ],
            'state' => [
                'string',
                Rule::requiredIf(function () {
                    return $this->input('deviceModelClassName') === DeviceModelClassName::Lighting->value;
                }),
            ],
            'occupiedHeatingSetpoint' => [
                'numeric',
                'min:15',
                'max:24',
                Rule::requiredIf(function () {
                    return $this->input('deviceModelClassName') === DeviceModelClassName::Heating->value;
                }),
            ],
        ];
    }
}
