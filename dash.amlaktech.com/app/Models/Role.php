<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];


    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }
}
