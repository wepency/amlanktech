<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelAccessories;

class Post extends Model
{
    use HasFactory, ModelAccessories;

    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function reactions()
    {
        return $this->hasMany(PostReaction::class);
    }

    public function likes()
    {
        return $this->hasMany(PostReaction::class)->where('type', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(PostReaction::class)->where('type', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
