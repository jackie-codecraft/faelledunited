<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasUlids;

    protected $fillable = [
        'subject',
        'body',
        'recipient_type',
        'recipient_ids',
        'status',
        'sent_at',
        'total_sent',
    ];

    protected $casts = [
        'recipient_ids' => 'array',
        'sent_at'       => 'datetime',
    ];

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent(Builder $query): Builder
    {
        return $query->where('status', 'sent');
    }
}
