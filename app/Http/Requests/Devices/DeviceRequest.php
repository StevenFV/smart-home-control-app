<?php

namespace App\Http\Requests\Devices;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    public function rules(): array
    {
        $startWithCapitalLetter = 'regex:/^[A-Z]/';

        return [
            'friendlyName' => ['required', 'string', 'max:81'],
            'set' => ['required', 'string', 'size:4', 'in:/set'],
            'state' => ['required', 'string'],
            'deviceModelClassName' => ['required', 'string', $startWithCapitalLetter],
        ];
    }
}
