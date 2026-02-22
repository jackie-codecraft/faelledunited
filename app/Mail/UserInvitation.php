<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public string $inviteUrl;
    public string $userLocale;

    public function __construct(public User $user)
    {
        $this->userLocale = $user->locale ?? 'da';
        $this->inviteUrl  = url('/invitation/' . $user->invite_token);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: trans('email.invite.subject', [], $this->userLocale),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-invitation',
            with: [
                'locale'    => $this->userLocale,
                'inviteUrl' => $this->inviteUrl,
                'userName'  => $this->user->name,
            ],
        );
    }
}
