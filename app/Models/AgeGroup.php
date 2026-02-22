<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgeGroup extends Model
{
    protected $fillable = ['department_id', 'slug', 'label_da', 'label_en', 'birth_year', 'gender', 'description_da', 'description_en', 'training_schedule', 'coach_info', 'sort_order', 'is_active'];

    protected $casts = ['training_schedule' => 'array', 'coach_info' => 'array'];

    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function registrations(): HasMany { return $this->hasMany(Registration::class); }

    public function label(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->label_en)
            ? $this->label_en
            : $this->label_da);
    }

    public function description(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->description_en)
            ? $this->description_en
            : $this->description_da);
    }
}
