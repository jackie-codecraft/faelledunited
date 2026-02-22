<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statute extends Model
{
    protected $fillable = [
        'content_da',
        'content_en',
    ];

    /**
     * Return the single statutes record, creating it if it doesn't exist yet.
     */
    public static function current(): static
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'content_da' => '',
                'content_en' => '',
            ]
        );
    }
}
