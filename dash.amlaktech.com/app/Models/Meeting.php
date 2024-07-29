<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];


    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

    public function agenda()
    {
        return $this->hasOne(MeetingAgenda::class);
    }

    public function decisions()
    {
        return $this->hasOne(MeetingDecision::class);
    }

}
