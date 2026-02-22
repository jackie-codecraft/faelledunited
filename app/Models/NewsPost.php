<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsPost extends Model
{
    protected $fillable = ['news_category_id', 'slug', 'title_da', 'title_en', 'excerpt_da', 'excerpt_en', 'body_da', 'body_en', 'featured_image', 'is_published', 'published_at'];
    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];

    public function category(): BelongsTo { return $this->belongsTo(NewsCategory::class, 'news_category_id'); }

    /** Returns the locale-appropriate title. */
    public function title(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->title_en)
            ? $this->title_en
            : $this->title_da);
    }

    /** Returns the locale-appropriate excerpt. */
    public function excerpt(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->excerpt_en)
            ? $this->excerpt_en
            : $this->excerpt_da);
    }

    /** Returns the locale-appropriate body. */
    public function body(): Attribute
    {
        return Attribute::get(fn () => app()->getLocale() === 'en' && !empty($this->body_en)
            ? $this->body_en
            : $this->body_da);
    }
}
