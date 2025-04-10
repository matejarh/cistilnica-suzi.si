<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SubscribersController;

// Public Routes
Route::name('public.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Landing');
    })->name('home');

    Route::get('/o-nas', function () {
        return Inertia::render('About');
    })->name('about');

    Route::get('/ponudba', function () {
        return Inertia::render('Offers');
    })->name('offers');

    Route::get('/kontakt', function () {
        return Inertia::render('Contact');
    })->name('contact');

    Route::get('/prijava-na-promocije', function () {
        return Inertia::render('Prijava');
    })->name('prijava');
});

// Subscriber Routes
Route::prefix('prijava-na-promocije')->name('subscribers.')->middleware('throttle:4,1')->group(function () {
    Route::get('/potrditev', [SubscribersController::class, 'store'])->name('store');
    Route::post('/potrditev', [SubscribersController::class, 'confirm'])->name('confirm');
    Route::delete('/', [SubscribersController::class, 'destroy'])->name('destroy');
});

// Test Routes
Route::get('/test-email', function () {
    $token = 'example-token';
    $email = 'example@example.com';

    return view('emails.confirm-subscription', compact('token', 'email'));
})->name('test.email');

// Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
