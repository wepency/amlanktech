<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDecision extends Model
{
    use HasFactory;

    protected $table = 'meeting_decisions';

    protected $guarded = ['id'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
