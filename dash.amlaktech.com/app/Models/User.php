<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password'
    ];

    public function association()
    {
        return $this->hasOneThrough(
            Association::class,
            AssociationsMembers::class,
            'user_id', // Foreign key on the intermediate model (AssociationsMembers)
            'id', // Foreign key on the target model (Association)
            'id', // Local key on the current model (AssociationsMembers)
            'association_id' // Local key on the target model (Association)
        );
    }

    public function associations()
    {
        return $this->hasManyThrough(
            Association::class,
            AssociationsMembers::class,
            'user_id', // Foreign key on the intermediate model (AssociationsMembers)
            'id', // Foreign key on the target model (Association)
            'id', // Local key on the current model (AssociationsMembers)
            'association_id' // Local key on the target model (Association)
        );
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class, 'association_member_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(PostReaction::class, 'user_id');
    }

    public function subscriptions(): HasManyThrough
    {
        return $this->hasManyThrough(Subscription::class, Unit::class, 'association_member_id', 'unit_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function permits(): HasMany
    {
        return $this->hasMany(Permit::class, 'member_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeNotActive($query)
    {
        return $query->whereNull('status');
    }

    public function memberAssociations()
    {
        return $this->belongsToMany(Association::class, 'associations_users', 'user_id', 'association_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'member_id');
    }
}
