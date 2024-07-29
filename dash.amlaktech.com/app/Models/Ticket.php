<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public const INPROGRESS = 'inProgress';
    public const SOLVED = 'solved';
    public const NOTSOLVED = 'notSolved';


    public function ticketMessages(): HasMany
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(TicketMessage::class)->orderBy('id', 'desc');
    }

    public function firstMessage()
    {
        return $this->hasOne(TicketMessage::class)->orderBy('id', 'asc');
    }

    public function member()
    {
        return $this->belongsTo(User::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function scopeSolved($query)
    {
        return $query->where('status', self::SOLVED);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', self::INPROGRESS);
    }

    public function scopeNotSolved($query)
    {
        return $query->where('status', self::NOTSOLVED);
    }

    public function attachment()
    {
        return $this->morphMany(Attachment::class, 'model');
    }
}
