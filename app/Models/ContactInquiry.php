<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInquiry extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'message', 'locale', 'status', 'assigned_to', 'internal_notes'];

    protected $casts = [
        'status' => 'string',
    ];

    public function assignedUser(): BelongsTo { return $this->belongsTo(User::class, 'assigned_to'); }
}
