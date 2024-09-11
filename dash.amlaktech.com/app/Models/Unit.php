<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $toFill = [
        'association_id',
        'fee_type_amount',
        'fee_type_total',
        'ownership_type',
        'partners_amount',
        'ownership_ratio',
        'address',
        'unit_no',
        'water_meter_serial',
        'electricity_meter_serial',
        'association_member_id',
        'sub_start_date',
        'notes',
        'status',
        'area'
    ];

    public $guarded = ['id'];

    public function associationMember(): BelongsTo
    {
        return $this->belongsTo(User::class, 'association_member_id');
    }

    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }


    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getTitle()
    {
        return trans('labels.gift');
    }
}
