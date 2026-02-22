<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailingListWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public string $userLocale;

    public function __construct(
        public readonly NewsletterSubscriber $subscriber,
        string $locale = 'da',
    ) {
        $this->userLocale = in_array($locale, ['da', 'en']) ? $locale : 'da';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: trans('email.mailing.subject', [], $this->userLocale),
        );
    }

    public function content(): Content
    {
        $unsubscribeUrl = route('unsubscribe.confirm', ['token' => $this->subscriber->token]);

        return new Content(
            view: 'emails.mailing-list-welcome',
            with: [
                'locale'         => $this->userLocale,
                'unsubscribeUrl' => $unsubscribeUrl,
            ],
        );
    }
}
