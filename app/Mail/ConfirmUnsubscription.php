<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmUnsubscription extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
    public $link;
    /**
     * Create a new message instance.
     */
    public function __construct(string $token, string $email, string $link)
    {
        $this->link = $link;
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Potrdi odjavo iz akcij',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.unsubscribe-confirmation',
            with: [
                'token' => $this->token,
                'email' => $this->email,
                'link' => $this->link,
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
