<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use  HasFactory, SoftDeletes, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'image',
        'email',
        'phone_number',
        'national_id',
        'password',
        'role',
        'profession',
        'salary',
        'address',
        'association_id',
        'deleted_at'
    ];

    protected $hidden = [
        'password'
    ];

    public function associations(): HasMany
    {
        return $this->hasMany(Association::class);
    }

    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }


    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function scopeManagers($query)
    {
        return $query->where(function ($query){
            $query->whereNull('role')->orWhereNotIn('role', ['admin', 'outsource']);
        });
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeEmployees($query)
    {
        return $query->where('role', 'employee');
    }

    public function scopeOutsourceEmployees($query)
    {
        $query->where('role', 'outsource');
    }
}
