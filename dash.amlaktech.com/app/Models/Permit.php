<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    //'association', 'member', 'visitors'

    protected $fillable = [
        'association_id',
        'code',
        'member_id',
        'status',
        'login_attempts',
        'permit_category_id',
        'start_date',
        'permit_days',
        'type'
    ];

    protected $casts = [
        'status' => 'boolean',
        'start_date' => 'date'
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function member()
    {
        return $this->belongsTo(AssociationMember::class);
    }

    public function visitors()
    {
        return $this->hasMany(PermitVisitor::class);
    }

    public function category()
    {
        return $this->belongsTo(PermitCategory::class);
    }
}
