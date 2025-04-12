<?php

namespace App\Mail;

use App\Models\Promotion;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromotionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $promotion;
    public $subscriber;

    /**
     * Create a new message instance.
     */
    public function __construct(Promotion $promotion, Subscriber $subscriber)
    {
        $this->promotion = $promotion;
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nova promocija: ' . $this->promotion->name)
            ->view('emails.promotion')
            ->with([
                'promotion' => $this->promotion,
                'subscriber' => $this->subscriber,
            ]);
    }
}
