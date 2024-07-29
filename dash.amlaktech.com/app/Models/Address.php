<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function associations(): HasMany
    {
        return $this->hasMany(Association::class);
    }

    public function associationMembers(): HasMany
    {
        return $this->hasMany(AssociationMember::class);
    }
}
