<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['slug', 'name_da', 'name_en', 'description_da', 'description_en', 'hero_image', 'sort_order', 'is_active'];

    public function ageGroups(): HasMany
    {
        return $this->hasMany(AgeGroup::class);
    }

    public function name(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->name_en)
            ? $this->name_en
            : $this->name_da);
    }

    public function description(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->description_en)
            ? $this->description_en
            : $this->description_da);
    }
}
