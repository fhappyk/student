<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserImported extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $data
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->data['email_template']->from,
            replyTo: $this->data['email_template']->reply_to,
            subject: $this->data['email_template']->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user_imported_markdown',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

