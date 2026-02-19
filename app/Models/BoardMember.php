<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    protected $fillable = ['name', 'role_da', 'role_en', 'bio_da', 'bio_en', 'photo', 'email', 'sort_order', 'is_active'];
}
