<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionType extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];

    public const UNIT = 1;
    public const PERSON = 2;
    public const FAMILY = 3;
    public const CAR = 4;
  
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
