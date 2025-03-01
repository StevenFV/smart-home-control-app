<?php

use App\Console\Commands\Devices\PublishMessage;
use App\Enums\Authenticate;
use App\Enums\Permission;
use App\Enums\Role;
use App\Http\Controllers\Devices\LightingController;
use App\Models\Devices\Lighting;
use Illuminate\Support\Facades\Route;

Route::middleware([Authenticate::Auth->value, Role::AdminOrUser->value])->group(
    function () {
        Route::get('devices/lighting', [LightingController::class, 'index'])->name('lighting.index')
            ->can(Permission::get, Lighting::class);
        Route::post('devices/lighting/set', [PublishMessage::class, 'handle'])
            ->can(Permission::set, Lighting::class)
            ->name('lighting.set');
        Route::get('devices/lighting/get', [LightingController::class, 'fetchDataForFrontend'])
            ->can(Permission::get, Lighting::class)
            ->name('lighting.get');
    },
);
