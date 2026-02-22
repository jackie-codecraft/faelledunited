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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
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
