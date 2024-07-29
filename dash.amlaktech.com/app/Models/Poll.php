<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];

   public function items(): HasMany
   {
       return $this->hasMany(PollItem::class);
   }

    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }
}
