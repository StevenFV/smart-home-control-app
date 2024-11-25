<?php

use App\Console\Commands\Devices\PublishMessage;
use App\Enums\PermissionRole;
use App\Http\Controllers\Devices\LightingController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    PermissionRole::Role->value . ':' . PermissionRole::Admin->value . '|' . PermissionRole::User->value,
])->group(function () {
    Route::get('devices/lighting', [LightingController::class, 'index'])->name('lighting.index');
    Route::post('devices/lighting/set', [PublishMessage::class, 'handle'])->name('lighting.set');
    Route::get('devices/lighting/get', [LightingController::class, 'fetchDataForFrontend'])->name('lighting.get');
});
