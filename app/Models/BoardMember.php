<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardMember extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'role_da',
        'role_en',
        'bio_da',
        'bio_en',
        'photo',
        'email',
        'sort_order',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
