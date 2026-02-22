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

    public function __construct(
        public readonly Registration $registration
    ) {
        $this->registration->loadMissing(['department', 'ageGroup']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tilmelding modtaget — ' . $this->registration->player_name . ' · Fælled United',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmation',
        );
    }
}
