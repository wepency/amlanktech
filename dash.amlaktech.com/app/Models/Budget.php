<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budget';

    protected $fillable = [
        'amount',
        'association_id',
        'association_member_id',
        'unit_id',
        'model_id',
        'model_type'
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function association()
    {
        return $this->belongsTo(Association::class)->withTrashed();
    }
}
