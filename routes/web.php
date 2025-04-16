<?php

use App\Enums\Authenticate;
use App\Enums\Web;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Authenticate::AuthSanctum->value && config(Authenticate::JetstreamAuthSession->value) &&
        Authenticate::Verified->value && Web::AdminOrUserOrGuest->value) {
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
        Web::AdminOrUserOrGuest->value,
    ],
)->group(function () {
    Route::get('app-lang-switch', function () {
        App::isLocale('en') ? $locale = 'fr' : $locale = 'en';
        session()->put('locale', $locale);

        /*
         * The Inertia::location() method will generate a 409 Conflict response and include the destination URL in the
         * X-Inertia-Location header.
         * When this response is received client-side,
         * Inertia will automatically perform a window.location = url visit.
         */
        return Inertia::location(url()->previous());
    })->name('app-lang.switch');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    require_once __DIR__ . '/Devices/lighting.php';
    require_once __DIR__ . '/Devices/heating.php';
});
