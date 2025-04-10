<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    /**
     * Handle subscription confirmation request.
     * Validates the email, generates a confirmation token, and sends a confirmation email.
     */
    public function confirm(Request $request)
    {
        // Validate the email input
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ],[
            'email.required' => 'Vnos elektronskega naslova je obvezen.',
            'email.email' => 'Vnesite veljaven elektronski naslov.',
            'email.unique' => 'Naslov ' . $request->input('email') . ' je že naročen na akcije.',
        ]);

        $email = $validated['email'];

        // Generate a unique confirmation token
        $token = sha1(uniqid($email, true));

        // Encrypt the email and token
        $encryptedEmail = encrypt($email);
        $encryptedToken = encrypt($token);

        // Store the email and token in the session
        session(['subscriber_confirmation' => [
            'email' => $encryptedEmail,
            'token' => $encryptedToken,
        ]]);

        // Send confirmation email
        \Mail::send('emails.confirm-subscription', ['token' => $encryptedToken, 'email' => $encryptedEmail], function ($message) use ($email) {
            $message->to($email)
                ->subject('Potrdite prijavo na akcije');
        });

        // Flash success message and redirect back
        session()->flash('flash.banner', 'Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>'.$email.'</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo prijavo.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', 'Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>'.$email.'</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo prijavo.');
    }

    /**
     * Store a new subscriber after confirmation.
     * Validates the token and email, then saves the subscriber to the database.
     */
    public function store(Request $request)
    {
        // Validate the token from the request against the session
        if ($request->input('token') !== session('subscriber_confirmation.token')) {
            session()->flash('flash.banner', 'Neveljaven ali potekel potrditveni žeton.');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back()->withErrors(['token' => 'Neveljaven ali potekel potrditveni žeton.']);
        }

        // Validate the email from the request against the session
        if ($request->input('email') !== session('subscriber_confirmation.email')) {
            session()->flash('flash.banner', 'Elektronski naslov se ne ujema z naslovom v seji.');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back()->withErrors(['email' => 'Elektronski naslov se ne ujema z naslovom v seji.']);
        }

        // Decrypt the token and email from the request
        $decryptedToken = decrypt(session('subscriber_confirmation.token'));
        $decryptedEmail = decrypt(session('subscriber_confirmation.email'));

        // dd(session('subscriber_confirmation'));
        // Save the subscriber to the database
        $subscriber = new Subscriber();
        $subscriber->email = $decryptedEmail;
        $subscriber->is_subscribed = true;
        $subscriber->ip_address = $request->ip();
        $subscriber->user_agent = $request->header('User-Agent');
        $subscriber->save();

        // Clear the session data after successful confirmation
        session()->forget('subscriber_confirmation');

        // Flash success message and redirect back
        session()->flash('flash.banner', 'Uspešno ste se prijavili na naše akcije.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', 'Uspešno ste se prijavili na naše akcije.');
    }

    /**
     * Handle unsubscription confirmation request.
     * Validates the email, generates a confirmation token, and sends a confirmation email.
     */
    public function unsubscribeConfirm(Request $request)
    {
        // Validate the email input
        $validated = $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ],[
            'email.required' => 'Vnos elektronskega naslova je obvezen.',
            'email.email' => 'Vnesite veljaven elektronski naslov.',
            'email.exists' => 'Naslov ' . $request->input('email') . ' ni naročen na akcije.',
        ]);

        $email = $validated['email'];

        // Generate a unique confirmation token
        $token = sha1(uniqid($email, true));

        // Encrypt the email and token
        $encryptedEmail = encrypt($email);
        $encryptedToken = encrypt($token);

        // Store the email and token in the session
        session(['subscriber_unsubscribe_confirmation' => [
            'email' => $encryptedEmail,
            'token' => $encryptedToken,
        ]]);

        // Send confirmation email
        \Mail::send('emails.unsubscribe-confirmation', ['token' => $encryptedToken, 'email' => $encryptedEmail], function ($message) use ($email) {
            $message->to($email)
                ->subject('Potrdite odjavo od akcij');
        });

        // Flash success message and redirect back
        session()->flash('flash.banner', 'Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>'.$email.'</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo odjavo.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', 'Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>'.$email.'</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo odjavo.');
    }
    /**
     * Handle unsubscription request.
     * Validates the token and email, then updates the subscriber's status in the database.
     */
    public function unsubscribeStore(Request $request)
    {
        // Validate the token from the request against the session
        if ($request->input('token') !== session('subscriber_unsubscribe_confirmation.token')) {
            session()->flash('flash.banner', 'Neveljaven ali potekel potrditveni žeton.');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back()->withErrors(['token' => 'Neveljaven ali potekel potrditveni žeton.']);
        }

        // Validate the email from the request against the session
        if ($request->input('email') !== session('subscriber_unsubscribe_confirmation.email')) {
            session()->flash('flash.banner', 'Elektronski naslov se ne ujema z naslovom v seji.');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back()->withErrors(['email' => 'Elektronski naslov se ne ujema z naslovom v seji.']);
        }

        // Decrypt the token and email from the request
        $decryptedToken = decrypt(session('subscriber_unsubscribe_confirmation.token'));
        $decryptedEmail = decrypt(session('subscriber_unsubscribe_confirmation.email'));

        // Find the subscriber and update their subscription status
        $subscriber = Subscriber::where('email', $decryptedEmail)->first();
        if ($subscriber) {
            $subscriber->is_subscribed = false;
            $subscriber->save();
        }

        // Clear the session data after successful unsubscription
        session()->forget('subscriber_unsubscribe_confirmation');

        // Flash success message and redirect back
        session()->flash('flash.banner', 'Uspešno ste se odjavili od naših akcij.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', 'Uspešno ste se odjavili od naših akcij.');
    }

    /**
     * Unsubscribe a user.
     * Validates the email and updates the subscription status in the database.
     */
    public function unsubscribe(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ],[
            'email.required' => 'Vnos elektronskega naslova je obvezen.',
            'email.email' => 'Vnesite veljaven elektronski naslov.',
            'email.exists' => 'Naslov ' . $request->input('email') . ' ni naročen na akcije.',
        ]);

        // Find the subscriber and update their subscription status
        $subscriber = Subscriber::where('email', $request->input('email'))->first();
        if ($subscriber) {
            $subscriber->is_subscribed = false;
            $subscriber->save();
        }

        // Flash success message and redirect back
        session()->flash('flash.banner', 'Uspešno ste se odjavili od naših akcij.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', 'Uspešno ste se odjavili od naših akcij.');
    }

    /**
     * Delete a subscriber.
     * Validates the email and removes the subscriber from the database.
     */
    public function destroy(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ],[
            'email.required' => 'Vnos elektronskega naslova je obvezen.',
            'email.email' => 'Vnesite veljaven elektronski naslov.',
            'email.exists' => 'Naslov ' . $request->input('email') . ' ni naročen na akcije.',
        ]);

        // Find and delete the subscriber
        $subscriber = Subscriber::where('email', $request->input('email'))->first();
        if ($subscriber) {
            $subscriber->delete();
        }

        // Flash success message and redirect back
        session()->flash('flash.banner', 'Uspešno ste izbrisali svojo naročnino.');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', 'Uspešno ste izbrisali svojo naročnino.');
    }
}
