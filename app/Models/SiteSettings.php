<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteSettings extends Model
{
    protected $fillable = [
        'contact_email',
        'default_inquiry_assignee_id',
        'registration_open',
        'registration_closed_message_da',
        'registration_closed_message_en',
        'facebook_url',
        'instagram_url',
    ];

    protected $casts = [
        'registration_open' => 'boolean',
    ];

    public function defaultAssignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'default_inquiry_assignee_id');
    }

    /**
     * Return the single settings record, seeding defaults on first access.
     */
    public static function current(): static
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'contact_email'      => 'info@faelledunited.dk',
                'registration_open'  => true,
                'facebook_url'       => 'https://www.facebook.com/groups/816017494322742',
                'instagram_url'      => 'https://www.instagram.com/faelledunited/',
            ]
        );
    }
}
