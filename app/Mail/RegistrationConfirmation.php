<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public string $userLocale;

    public function __construct(
        public readonly Registration $registration,
        string $locale = 'da',
    ) {
        $this->userLocale = in_array($locale, ['da', 'en']) ? $locale : 'da';
        $this->registration->loadMissing(['department', 'ageGroup']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: trans('email.registration.subject', ['name' => $this->registration->player_name], $this->userLocale),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmation',
            with: ['locale' => $this->userLocale],
        );
    }
}
