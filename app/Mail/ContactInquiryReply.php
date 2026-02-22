<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryReply extends Mailable
{
    use Queueable, SerializesModels;

    public string $userLocale;

    public function __construct(
        public readonly ContactInquiry $inquiry,
        public readonly string $replyMessage,
        string $locale = null,
    ) {
        $raw = $locale ?? $inquiry->locale ?? 'da';
        $this->userLocale = in_array($raw, ['da', 'en']) ? $raw : 'da';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: trans('email.inquiry_reply.subject', [], $this->userLocale),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-inquiry-reply',
            with: ['locale' => $this->userLocale],
        );
    }
}
