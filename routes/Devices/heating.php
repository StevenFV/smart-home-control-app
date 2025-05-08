<?php

use App\Console\Commands\Devices\PublishMessage;
use App\Enums\Permission as PermissionEnums;
use App\Http\Controllers\Devices\HeatingController;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;

Route::get('devices/heating', [HeatingController::class, 'index'])->name('heating.index')
    ->can(PermissionEnums::ViewDevices->value, Permission::class);
Route::post('devices/heating/set', [PublishMessage::class, 'handle'])
    ->can(PermissionEnums::ControlDevices->value, Permission::class)
    ->name('heating.set');
