<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    use HasFactory;

    protected $table = 'poll_votes';

    protected $guarded = ['id'];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function item()
    {
        return $this->belongsTo(PollItem::class);
    }

    public function user()
    {
        return $this->morphTo('user', 'user_model', 'user_id');
    }
}
