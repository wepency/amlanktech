<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Association extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'map_link',
        'registration_number',
        'registration_certificate',
        'subscription_period',
        'subscription_start_date',
        'fee_type_id',
        'fee_amount',
        'address',
        'postal_code',
        'city_id',
//        'admin_id'
    ];

    protected $casts = [
        'subscription_start_date' => 'date'
    ];

    // If you want to set a default format, you can use an accessor
    public function getSubscriptionStartDateAttribute($value)
    {
        // Assuming the database stores dates in the 'Y-m-d' format
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id', 'id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function manager()
    {
        return $this->hasOne(Admin::class, 'association_id', 'id');
    }

    public function associationMembers(): HasMany
    {
        return $this->hasMany(AssociationMember::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function policies(): HasMany
    {
        return $this->hasMany(Policy::class);
    }
}
