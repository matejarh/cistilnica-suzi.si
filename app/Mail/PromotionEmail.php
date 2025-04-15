<?php

namespace App\Mail;

use App\Models\Promotion;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PromotionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $promotion;
    public $subscriber;
    public $unsubscribeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Promotion $promotion, Subscriber $subscriber, string $unsubscribeUrl = null)
    {
        $this->promotion = $promotion;
        $this->subscriber = $subscriber;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Nova promocija: {$this->promotion->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.promotion',
            with: [
                'promotion' => $this->promotion,
                'subscriber' => $this->subscriber,
                'unsubscribeUrl' => $this->unsubscribeUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
