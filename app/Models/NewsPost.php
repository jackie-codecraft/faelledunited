<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsPost extends Model
{
    protected $fillable = ['news_category_id', 'slug', 'title_da', 'title_en', 'excerpt_da', 'excerpt_en', 'body_da', 'body_en', 'featured_image', 'is_published', 'published_at'];
    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];

    public function category(): BelongsTo { return $this->belongsTo(NewsCategory::class, 'news_category_id'); }
}
