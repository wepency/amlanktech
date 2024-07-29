<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use HasFactory, ModelTrait;

    // status: 1: waiting for approval, 2: image added ,3: approved, 4: rejected

    protected $guarded = ['id'];

    const INCOME = 'income';
    const PAYMENT = 'payment';

    public function getTitle()
    {
        if ($this->receipt_type == self::INCOME) {
            return 'سند قبض';
        }

        return 'سند صرف';
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function associationMember()
    {
        return $this->belongsTo(AssociationMember::class);
    }

    public function scopeValid($query)
    {
        return $query->where('status', 1);
    }

    public function scopeAssociationUnits($query)
    {
        return $query->where('association_id', get_auth()->user()->association_id);
    }
}
