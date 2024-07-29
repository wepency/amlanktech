<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];

    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

}
