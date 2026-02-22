<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    protected $fillable = ['slug', 'name_da', 'name_en'];

    public function posts(): HasMany { return $this->hasMany(NewsPost::class); }

    /** Returns the locale-appropriate category name. */
    public function name(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->name_en)
            ? $this->name_en
            : $this->name_da);
    }
}
