<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
   
    public function member(): BelongsTo
    {
        return $this->belongsTo(AssociationMember::class, 'member_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }
}
