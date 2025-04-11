<?php

namespace App\Http\Controllers\Devices;

use App\Enums\DeviceModelClassName;
use App\Http\Controllers\Controller;
use App\Models\Devices\Lighting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Inertia\Response;

class LightingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Lighting/Index', [
            'lightings' => fn () => $this->store(),
        ]);
    }

    public function store(): Collection
    {
        Artisan::call('device:store-data', ['deviceModelClassName' => DeviceModelClassName::Lighting->value]);

        return Lighting::query()
            ->select('friendly_name', 'brightness', 'energy', 'linkquality', 'power', 'state')
            ->orderBy('friendly_name')
            ->get();
    }
}
