<?php

namespace App\Traits;

trait ModelAccessories
{
    public function scopeBelongsToAssociation($query, $associationId)
    {
        return $query->where('association_id', $associationId);
    }

    public function scopeBelongsToAssociations($query, $associations)
    {
        return $query->whereIn('association_id', $associations);
    }
}
