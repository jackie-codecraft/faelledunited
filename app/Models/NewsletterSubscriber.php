<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'locale', 'confirmed', 'confirmed_at', 'token'];
    protected $casts = ['confirmed' => 'boolean', 'confirmed_at' => 'datetime'];
}
