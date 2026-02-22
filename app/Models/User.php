<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
        'invite_token',
        'invite_sent_at',
        'invite_accepted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',
            'invite_sent_at'      => 'datetime',
            'invite_accepted_at'  => 'datetime',
        ];
    }

    /** Generate a fresh invite token and stamp the sent time. */
    public function generateInviteToken(): string
    {
        $token = \Illuminate\Support\Str::random(64);
        $this->update([
            'invite_token'       => $token,
            'invite_sent_at'     => now(),
            'invite_accepted_at' => null,
        ]);
        return $token;
    }

    public function inviteStatus(): string
    {
        if ($this->invite_accepted_at) return 'active';
        if ($this->invite_sent_at)     return 'pending';
        return 'none';
    }

    public function isInviteExpired(): bool
    {
        return $this->invite_sent_at
            && $this->invite_accepted_at === null
            && $this->invite_sent_at->lt(now()->subDays(7));
    }

    public function boardMember(): HasOne
    {
        return $this->hasOne(BoardMember::class);
    }

    public function isBoardMember(): bool
    {
        return $this->boardMember()->exists();
    }

    /**
     * All registered users can access the admin panel.
     * Add role checks here when role-based access is implemented.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
