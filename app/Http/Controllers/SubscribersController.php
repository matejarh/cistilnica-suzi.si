<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmSubscription;
use App\Mail\ConfirmUnsubscription;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class SubscribersController extends Controller
{
    /**
     * Handle subscription confirmation request.
     * Validates the email, generates a confirmation token, and sends a confirmation email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], $this->validationMessages());

        $email = $validated['email'];
        $token = hash_hmac('sha256', uniqid($email, true), config('app.key'));
        $sessionKey = "subscriber_confirmation_$token";

        Session::put($sessionKey, [
            'email' => $email,
            'token' => $token,
        ]);

        Log::debug('Subscription session stored', [
            'key' => $sessionKey,
            'data' => Session::get($sessionKey),
        ]);

        $link = route('subscribers.store', [
            'email' => encrypt($email),
            'token' => $token,
        ]);

        Mail::to($email)->send(new ConfirmSubscription($token, encrypt($email), $link));

       /*  Mail::send('emails.confirm-subscription', [
            'token' => $token,
            'email' => encrypt($email),
        ], function ($message) use ($email) {
            $message->to($email)->subject('Potrdite prijavo na akcije');
        }); */

        return $this->flashAndRedirect("Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>$email</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo prijavo.");
    }

    /**
     * Store a new subscriber after confirmation.
     * Validates the token and email, then saves the subscriber to the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $token = $request->input('token');

        $sessionKey = "subscriber_confirmation_$token";
        $sessionData = $this->validateSession($sessionKey, $request);

        Subscriber::create([
            'email' => $sessionData['email'],
            'is_subscribed' => true,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        Session::forget($sessionKey);

        return $this->flashAndRedirect('Uspešno ste se prijavili na naše akcije.', 'public.home');
    }

    /**
     * Show the unsubscribe form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function unsubscribe(Request $request)
    {
        return Inertia::render('Subscribers/Unsubscribe', [
            'email' => decrypt(request('email')),
            'token' => request('token'),
        ]);
    }

    /**
     * Handle unsubscription confirmation request.
     * Validates the email, generates a confirmation token, and sends a confirmation email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function unsubscribeConfirm(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ], $this->validationMessages());

        $email = $validated['email'];

        if (!Subscriber::where('email', $email)->where('is_subscribed', true)->exists()) {
            return redirect()->back()->withErrors([
                'email' => 'Ta elektronski naslov je že odjavljen.',
            ]);
        }

        $token = hash_hmac('sha256', uniqid($email, true), config('app.key'));
        $sessionKey = "subscriber_unsubscribe_confirmation_$token";

        Session::put($sessionKey, [
            'email' => $email,
            'token' => $token,
        ]);

        Log::debug('Unsubscribe session stored', [
            'key' => $sessionKey,
            'data' => Session::get($sessionKey),
        ]);

        $link = route('subscribers.unsubscribe.store', [
            'email' => encrypt($email),
            'token' => $token,
        ]);

        Mail::to($email)->send(new ConfirmUnsubscription($token, encrypt($email), $link));


        /* Mail::send('emails.unsubscribe-confirmation', [
            'token' => $token,
            'email' => encrypt($email),
        ], function ($message) use ($email) {
            $message->to($email)->subject('Potrdite odjavo od akcij');
        }); */

        return $this->flashAndRedirect("Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>$email</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo odjavo.");
    }

    /**
     * Handle unsubscription request.
     * Validates the token and email, then updates the subscriber's status in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribeStore(Request $request)
    {
        $token = $request->input('token');
        $sessionKey = "subscriber_unsubscribe_confirmation_$token";
        $sessionData = $this->validateSession($sessionKey, $request);

        Subscriber::where('email', $sessionData['email'])->delete();
        Session::forget($sessionKey);

        return $this->flashAndRedirect('Uspešno ste se odjavili od naših akcij.', 'public.home');
    }

    /**
     * Delete a subscriber.
     * Validates the email and removes the subscriber from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ], $this->validationMessages());

        // Delete the subscriber
        Subscriber::where('email', $request->input('email'))->delete();

        // Flash success message and redirect back
        return $this->flashAndRedirect('Uspešno ste izbrisali svojo naročnino.');
    }

    /**
     * Centralized validation messages.
     *
     * @return array
     */
    private function validationMessages()
    {
        return [
            'email.required' => 'Vnos elektronskega naslova je obvezen.',
            'email.email' => 'Vnesite veljaven elektronski naslov.',
            'email.unique' => 'Naslov je že naročen na akcije.',
            'email.exists' => 'Naslov ni naročen na akcije.',
        ];
    }

    /**
     * Validate session data for confirmation or unsubscription.
     *
     * @param string $sessionKey
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateSession(string $sessionKey, Request $request): array
    {
        $sessionData = Session::get($sessionKey);

        Log::debug('Validating session data', [
            'sessionKey' => $sessionKey,
            'sessionData' => $sessionData,
            'requestData' => $request->all(),
            'availableSessionKeys' => array_keys(Session::all()),
        ]);

        if (!$sessionData || !isset($sessionData['email'], $sessionData['token'])) {
            session()->flash('flash.banner', 'Seja je potekla ali ni veljavna.');
            session()->flash('flash.bannerStyle', 'danger');
            abort(403, 'Seja je potekla ali ni veljavna. Zahtevek mora biti oddan in potrjen v istem brskalniku. Če vam povezava v potrditvenem sporočilu odpre drug brskalnik, kot pa je bil ta v katerem ste vnesli svoj email, bo seja neveljavna!');
        }

        if (decrypt($request->input('email')) !== $sessionData['email']) {
            session()->flash('flash.banner', 'Elektronski naslov ni veljaven.');
            session()->flash('flash.bannerStyle', 'danger');
            abort(403, 'Elektronski naslov ni veljaven.');
        }

        if ($request->input('token') !== $sessionData['token']) {
            session()->flash('flash.banner', 'Neveljaven ali potekel potrditveni žeton.');
            session()->flash('flash.bannerStyle', 'danger');
            abort(403, 'Neveljaven ali potekel potrditveni žeton.');
        }

        return $sessionData;
    }

    /**
     * Flash a success message and redirect back.
     *
     * @param string $message
     * @param string|null $route
     * @return \Illuminate\Http\RedirectResponse
     */
    private function flashAndRedirect(string $message, ?string $route = null)
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        return $route
            ? redirect()->route($route)->with('success', $message)
            : redirect()->back()->with('success', $message);
    }
}
