<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('locale/{locale}', function (string $locale) {
    $locale === 'en' ? $locale = 'fr' : $locale = 'en';
    Session::Put('locale', $locale);

    return Inertia::location(url()->previous());
})->name('locale');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    require_once __DIR__ . '/Devices/lighting.php';
});
