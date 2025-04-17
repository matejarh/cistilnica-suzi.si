<?php

use App\Http\Controllers\InquiriesController;
use App\Http\Controllers\PromotionsController;
use App\Models\Inquiry;
use App\Models\Promotion;
use App\Models\Subscriber;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SubscribersController;

// Public Routes
Route::name('public.')->middleware('throttle:60,1')->group(function () {
    Route::get('/', fn() => Inertia::render('Landing'))->name('home');

    Route::get('/o-nas', fn() => Inertia::render('About'))->name('about');

    Route::get('/ponudba', fn() => Inertia::render('Offers'))->name('offers');

    Route::get('/kontakt', fn() => Inertia::render('Contact'))->name('contact');

    Route::get('/akcije', [PromotionsController::class, 'akcije'])->name('akcije');
    Route::get('/akcije/activne', [PromotionsController::class, 'active'])->name('promotions.active');
});


// Inquiries Public Routes
Route::prefix('povprasevanja')->name('inquiries.')->middleware('throttle:10,1')->group(function () {
    Route::get('/potrditev', [InquiriesController::class, 'store'])->name('store');
    Route::post('/potrditev', [InquiriesController::class, 'sendConfirmationEmail'])->name('confirm');
});

// Subscriber Public Routes
Route::prefix('promocije')->name('subscribers.')->middleware('throttle:10,1')->group(function () {
    Route::post('/prijava', [SubscribersController::class, 'confirm'])->name('confirm');
    Route::get('/prijava', [SubscribersController::class, 'store'])->name('store');
    Route::get('/odjava', [SubscribersController::class, 'unsubscribe'])->name('unsubscribe');
    Route::post('/odjava', [SubscribersController::class, 'unsubscribeConfirm'])->name('unsubscribe.confirm');
    Route::get('/odjavi', [SubscribersController::class, 'unsubscribeStore'])->name('unsubscribe.store');
    Route::delete('/', [SubscribersController::class, 'destroy'])->name('destroy');
});


// Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/nadzorna-plosca', fn() => Inertia::render('Dashboard'))->name('dashboard');

    Route::prefix('povprasevanja')->name('inquiries.')->group(function () {
        Route::get('/', [InquiriesController::class, 'index'])->name('index');
        Route::get('/{inquiry}', [InquiriesController::class, 'show'])->name('show');
        Route::delete('/{inquiry}', [InquiriesController::class, 'destroy'])->name('destroy');
        Route::get('/{inquiry}/edit', [InquiriesController::class, 'edit'])->name('edit');
        Route::put('/{inquiry}', [InquiriesController::class, 'update'])->name('update');
        Route::get('/{inquiry}/restore', [InquiriesController::class, 'restore'])->name('restore');
        Route::get('/{inquiry}/delete', [InquiriesController::class, 'delete'])->name('delete');
        Route::post('/{inquiry}/reply', [InquiriesController::class, 'reply'])->name('reply');
    });

    Route::prefix('narocniki')->name('subscribers.')->group(function () {
        Route::get('/', [SubscribersController::class, 'index'])->name('index');
        Route::post('/', [SubscribersController::class, 'storeNewSubscriber'])->name('store.admin');
        Route::get('/{subscriber}', [SubscribersController::class, 'show'])->name('show');
        /* Route::delete('/{subscriber}', [SubscribersController::class, 'destroy'])->name('destroy'); */
        Route::get('/{subscriber}/edit', [SubscribersController::class, 'edit'])->name('edit');
        Route::put('/{subscriber}', [SubscribersController::class, 'update'])->name('update');
        Route::put('/{subscriber}/send', [SubscribersController::class, 'send'])->name('send');
    });
    Route::prefix('promocije')->name('promotions.')->group(function () {
        Route::get('/', [PromotionsController::class, 'index'])->name('index');
        Route::post('/', [PromotionsController::class, 'store'])->name('store');
        Route::get('/{promotion}', [PromotionsController::class, 'show'])->name('show');
        Route::delete('/{promotion}', [PromotionsController::class, 'destroy'])->name('destroy');
        Route::get('/{promotion}/edit', [PromotionsController::class, 'edit'])->name('edit');
        Route::put('/{promotion}', [PromotionsController::class, 'update'])->name('update');
        Route::post('/{promotion}/send', [PromotionsController::class, 'send'])->name('send');
    });
});


// Test Routes
if (app()->environment('local')) {
    Route::get('/test-email/{template}', function () {
        $template = request('template');
        $email = fake()->safeEmail();
        $token = hash_hmac('sha256', $email, config('app.key'));
        $email = encrypt($email);
        $unsubscribeUrl = route('subscribers.unsubscribe', ['email' => $email, 'token' => $token]);
        $link = route('subscribers.unsubscribe', ['email' => $email, 'token' => $token]);
        $unsubscribeUrl = str_replace('http://localhost:8000', 'https://www.example.com', $unsubscribeUrl);
        $data = [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'address' => fake()->address(),
            'subject' => fake()->sentence(),
            'message' => fake()->paragraph(),
        ];
        $inquiry = Inquiry::first();
        $promotion = Promotion::first();
        $subscriber = Subscriber::first();
        $reply = [
            'message' => fake()->paragraph(),
            'email' => fake()->safeEmail(),
        ];
        $message= fake()->paragraph();


        return view("emails.{$template}", compact('token', 'email', 'data', 'inquiry', 'promotion', 'subscriber', 'link', 'unsubscribeUrl', 'reply', 'message'));
    })->name('test.email');
}
