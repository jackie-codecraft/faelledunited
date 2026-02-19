<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = ['department_id', 'age_group_id', 'player_name', 'date_of_birth', 'current_club_experience', 'parent_name', 'parent_email', 'address', 'phone', 'additional_info', 'gdpr_consent', 'photo_consent', 'status', 'internal_notes'];

    protected $casts = ['date_of_birth' => 'date', 'gdpr_consent' => 'boolean', 'photo_consent' => 'boolean'];

    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function ageGroup(): BelongsTo { return $this->belongsTo(AgeGroup::class); }
}
