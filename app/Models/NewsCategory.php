<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    protected $fillable = ['slug', 'name_da', 'name_en'];

    public function posts(): HasMany { return $this->hasMany(NewsPost::class); }
}
