<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public string $userLocale;

    public function __construct(
        public readonly ContactInquiry $inquiry,
        string $locale = 'da',
    ) {
        $this->userLocale = in_array($locale, ['da', 'en']) ? $locale : 'da';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: trans('email.contact.subject', [], $this->userLocale),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-inquiry',
            with: ['locale' => $this->userLocale],
        );
    }
}
