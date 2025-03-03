<?php

use App\Enums\Authenticate;
use App\Enums\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

Route::get('/', function () {
    if (Authenticate::AuthSanctum->value && config(Authenticate::JetstreamAuthSession->value) &&
        Authenticate::Verified->value && Role::AdminOrUserOrGuest->value) {
        return redirect()->route('dashboard');
    }

    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(
    [
        Authenticate::AuthSanctum->value,
        config(Authenticate::JetstreamAuthSession->value),
        Authenticate::Verified->value,
        Role::AdminOrUserOrGuest->value,
    ],
)->group(function () {
    Route::get('locale/{locale}', function (string $locale) {
        $locale === 'en' ? $locale = 'fr' : $locale = 'en';
        Session::Put('locale', $locale);

        return Inertia::location(url()->previous());
    })->name('locale');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    require_once __DIR__ . '/Devices/lighting.php';
});
