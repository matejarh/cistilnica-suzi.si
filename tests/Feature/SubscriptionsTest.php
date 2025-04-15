<?php

namespace Tests\Feature;

use App\Mail\ConfirmSubscription;
use App\Mail\ConfirmUnsubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test if user can subscribe to promotions
     */
    public function test_user_can_render_subscription_form_test(): void
    {
        $response = $this->get(route('public.home'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn(AssertableInertia $page) =>
            $page
                ->component('Landing') // or the actual Vue component name
                //->has('promotions') // or whatever props you're passing

        );
    }

    /**
     * Test mail has been sent on subscription
     *
     */
    public function test_user_can_subscribe_to_promotions(): void
    {
        Mail::fake();
        $email = $this->faker->safeEmail();

        $response = $this->post(route('subscribers.confirm'), [
            'email' => $email,
        ]);

        $this->assertDatabaseMissing('subscribers', ['email' => $email]);
        $response->assertStatus(302);
        $response->assertSessionHas('flash.banner', 'Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>' . $email . '</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svojo prijavo.');

        $response->assertSessionHasNoErrors();

        $link = null;
        Mail::assertQueued(ConfirmSubscription::class, function ($mail) use ($email, &$capturedMail) {
            $capturedMail = $mail; // Capture the mail instance for later use
            return
            $mail->hasTo($email) &&
            $mail->token &&
            $mail->email;
        });

        // Now you can use $capturedMail->token and $capturedMail->email
        $token = $capturedMail->token;

        $response->assertSessionHas("subscriber_confirmation_$token");
        $capturedEmail = $capturedMail->email;

        $link = route('subscribers.store', [
            'email' => $capturedEmail,
            'token' => $token,
        ]);

        $response = $this->get($link);
        $response->assertStatus(302);
        $response->assertSessionHas('flash.banner', 'Uspešno ste se prijavili na naše akcije.');
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('subscribers', [
            'email' => decrypt($capturedEmail),
            'is_subscribed' => true,
        ]);

        $response = $this->post(route('subscribers.confirm'), [
            'email' => $email,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'email' => 'Naslov je že naročen na akcije.',
        ]);

    }

    /**
     * Test mail has been sent on unsubscription
     *
     */
    public function test_user_can_unsubscribe_to_promotions(): void
    {
        Mail::fake();
        $email = $this->faker->safeEmail();

        $response = $this->post(route('subscribers.unsubscribe.confirm'), [
            'email' => $email,
        ]);

        // $this->assertDatabaseHas('subscribers', ['email' => $email]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'email' => 'Naslov ni naročen na akcije.',
        ]);

        $subscriber = \App\Models\Subscriber::factory()->create([
            'email' => $email,
            'is_subscribed' => true,
        ]);

        $response = $this->post(route('subscribers.unsubscribe.confirm'), [
            'email' => $email,
        ]);

        $response->assertSessionHasNoErrors();

        Mail::assertQueued(ConfirmUnsubscription::class, function ($mail) use ($email, &$capturedMail) {
            $capturedMail = $mail; // Capture the mail instance for later use
            return
            $mail->hasTo($email) &&
            $mail->token &&
            $mail->email;
        });

        $token = $capturedMail->token;

        $response->assertSessionHas("subscriber_unsubscribe_confirmation_$token");
        $capturedEmail = $capturedMail->email;

        $link = route('subscribers.unsubscribe.store', [
            'email' => $capturedEmail,
            'token' => $token,
        ]);
        $response = $this->get($link);
        $response->assertStatus(302);
        $response->assertSessionHas('flash.banner', 'Uspešno ste se odjavili od naših akcij.');
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('subscribers', [
            'email' => decrypt($capturedEmail),
            'is_subscribed' => true,
        ]);
    }

    /**
     * Test if user can unsubscribe from promotions
     */
    // public function test_user_can_unsubscribe_from_promotions(): void
}
