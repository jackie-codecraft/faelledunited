<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ContactInquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $userLocale;
    public string $replyUrl;

    public function __construct(
        public readonly ContactInquiry $inquiry,
        string $locale = 'da',
    ) {
        $this->userLocale = in_array($locale, ['da', 'en']) ? $locale : 'da';
        $this->replyUrl = URL::signedRoute('contact.inquiry.reply', ['inquiry' => $inquiry->id]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: trans('email.inquiry_notification.subject', ['name' => $this->inquiry->name], $this->userLocale),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-inquiry-notification',
            with: [
                'locale'   => $this->userLocale,
                'replyUrl' => $this->replyUrl,
            ],
        );
    }
}
