<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageToSubscriber extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    public $customMessage;
    public $subscriber;
    public $unsubscribeUrl;
    /**
     * Create a new message instance.
     */
    public function __construct(string $customMessage, Subscriber $subscriber, string $unsubscribeUrl = null)
    {
        $this->customMessage = $customMessage;
        $this->subscriber = $subscriber;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sporočilo iz Čistilnice Suzi',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.message-to-subscriber',
            with: [
                'custom_message' => (string) $this->customMessage,
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
