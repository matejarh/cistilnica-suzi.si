<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyToInquiry extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The inquiry instance.
     *
     * @var \App\Models\Inquiry
     */
    public $inquiry;
    public $reply;
    /**
     * Create a new message instance.
     */
    public function __construct(Inquiry $inquiry, array $reply)
    {
        $this->inquiry = $inquiry;
        $this->reply = $reply;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Odgovor na poizvedbo',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reply-to-inquiry',
            with: [
                'inquiry' => $this->inquiry,
                'reply' => $this->reply,
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
