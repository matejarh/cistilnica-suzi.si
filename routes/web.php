<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing', [
/*         'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION, */
    ]);
})->name('home');

Route::get('/o-nas', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/cenik', function () {
    return Inertia::render('Prices');
})->name('prices');

Route::get('/kontakt', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/prijava-na-promocije', function () {
    return Inertia::render('Prijava');
})->name('prijava');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
