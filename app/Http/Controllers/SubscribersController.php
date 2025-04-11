<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        // Validate the email input
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], $this->validationMessages());

        $email = $validated['email'];

        // Generate a unique confirmation token
        $token = hash_hmac('sha256', uniqid($email, true), config('app.key'));

        // Store the hashed token and email in the session
        session(['subscriber_confirmation' => [
            'email' => $email,
            'token' => $token,
        ]]);

        // Send confirmation email
        Mail::send('emails.confirm-subscription', ['token' => $token, 'email' => encrypt($email)], function ($message) use ($email) {
            $message->to($email)
                ->subject('Potrdite prijavo na akcije');
        });

        // Flash success message and redirect back
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
        // Validate session data
        $this->validateSession('subscriber_confirmation', $request);

        $email = session('subscriber_confirmation.email');

        // Save the subscriber to the database
        Subscriber::create([
            'email' => $email,
            'is_subscribed' => true,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        // Clear the session data
        session()->forget('subscriber_confirmation');

        // Flash success message and redirect back
        return $this->flashAndRedirect('Uspešno ste se prijavili na naše akcije.');
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
        // Validate the email input
        $validated = $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ], $this->validationMessages());

        // Check if the email is already unsubscribed
        if (!Subscriber::where('email', $validated['email'])->where('is_subscribed', true)->exists()) {
            return redirect()->back()->withErrors([
            'email' => 'Ta elektronski naslov je že odjavljen.',
            ]);
        }

        $email = $validated['email'];

        // Generate a unique confirmation token
        $token = hash_hmac('sha256', uniqid($email, true), config('app.key'));

        // Store the hashed token and email in the session
        session(['subscriber_unsubscribe_confirmation' => [
            'email' => $email,
            'token' => $token,
        ]]);

        // Send confirmation email
        Mail::send('emails.unsubscribe-confirmation', ['token' => $token, 'email' => encrypt($email)], function ($message) use ($email) {
            $message->to($email)
                ->subject('Potrdite odjavo od akcij');
        });

        // Flash success message and redirect back
        return $this->flashAndRedirect("Potrditveno elektronsko sporočilo je bilo poslano na naslov <b></b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo odjavo.");
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
        // Validate session data
        $this->validateSession('subscriber_unsubscribe_confirmation', $request);

        $email = session('subscriber_unsubscribe_confirmation.email');

        // Update the subscriber's status
        Subscriber::where('email', $email)->delete();

        // Clear the session data
        session()->forget('subscriber_unsubscribe_confirmation');

        // Flash success message and redirect back
        return $this->flashAndRedirect('Uspešno ste se odjavili od naših akcij.');
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
    private function validateSession($sessionKey, Request $request)
    {
        $sessionData = session()->get($sessionKey);

        if (!$sessionData) {
            session()->flash('flash.banner', 'Seja je potekla ali ni veljavna.');
            session()->flash('flash.bannerStyle', 'danger');
            abort(403, 'Seja je potekla ali ni veljavna.');
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
    }

    /**
     * Flash a success message and redirect back.
     *
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    private function flashAndRedirect($message)
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', $message);
    }
}
