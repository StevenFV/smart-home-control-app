<?php

namespace App\Http\Controllers\Devices;

use App\Enums\DeviceModelClassName;
use App\Http\Controllers\Controller;
use App\Models\Devices\Heating;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Inertia\Response;

class HeatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Heating/Index', [
            'heatings' => fn () => $this->store(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(): Collection
    {
        Artisan::call('device:store-data', ['deviceModelClassName' => DeviceModelClassName::Heating->value]);

        return Heating::query()
            ->select(
                'friendly_name',
                'energy',
                'keypad_lockout',
                'linkquality',
                'local_temperature',
                'occupied_heating_setpoint',
                'pi_heating_demand',
                'power',
                'running_state',
                'system_mode',
                'temperature_display_mode',
            )
            ->orderBy('friendly_name')
            ->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
