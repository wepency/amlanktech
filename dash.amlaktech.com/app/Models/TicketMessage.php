<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];


    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class , 'ticket_id');
    }

    public function sender()
    {
        return $this->morphTo('sender', 'sender_type', 'sender_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'model');
    }
}
