<?php

namespace App\Models;

use App\Traits\ModelAccessories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationSystem extends Model
{
    use HasFactory, ModelAccessories;

    public function scopeForUsers($query)
    {
        return $query->where('show_users', 1);
    }
}
