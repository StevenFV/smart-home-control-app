<?php

use App\Console\Commands\Devices\PublishMessage;
use App\Enums\Permission as PermissionEnums;
use App\Http\Controllers\Devices\LightingController;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;

Route::get('devices/lighting', [LightingController::class, 'index'])->name('lighting.index')
    ->can(PermissionEnums::ViewDevices->value, Permission::class);
Route::post('devices/lighting/set', [PublishMessage::class, 'handle'])
    ->can(PermissionEnums::ControlDevices->value, Permission::class)
    ->name('lighting.set');
Route::get('devices/lighting/get', [LightingController::class, 'fetchDataForFrontend'])
    ->can(PermissionEnums::ViewDevices->value, Permission::class)
    ->name('lighting.get');
