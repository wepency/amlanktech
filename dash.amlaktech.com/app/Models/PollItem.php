<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollItem extends Model
{
    use HasFactory;

    protected $table = 'poll_items';

    protected $guarded = ['id'];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, PollVote::class);
    }
}
