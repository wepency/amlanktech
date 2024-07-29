<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getTitle()
    {
        return 'اشتراك';
    }

    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function subscriptionType(): BelongsTo
    {
        return $this->belongsTo(subscriptionType::class);
    }
}
