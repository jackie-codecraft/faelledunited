<?php

namespace App\Mail;

use App\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $userLocale;

    public function __construct(
        public readonly Newsletter $newsletter,
        public readonly string $recipientName,
        public readonly string $recipientEmail,
        string $locale = 'da',
    ) {
        $this->userLocale = in_array($locale, ['da', 'en']) ? $locale : 'da';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->newsletter->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter',
            with: [
                'newsletter' => $this->newsletter,
                'locale'     => $this->userLocale,
            ],
        );
    }
}
