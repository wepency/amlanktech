<?php

namespace App\Traits;

use App\Models\Association;

trait ModelTrait
{
    public function scopeAssociationUnits($query)
    {
        return $query->where('association_id', get_auth()->user()->association_id);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }
}
