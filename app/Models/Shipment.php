<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'tracking_id',
    'status',
    'sender_name',
    'sender_email',
    'sender_phone',
    'sender_address',
    'receiver_name',
    'receiver_email',
    'receiver_phone',
    'receiver_address',
    'parcel_weight',
    'parcel_category',
    'parcel_description',
    'parcel_value',
    'shipping_method',
    'dispatch_date',
    'estimated_delivery_date',
    'origin_location_id',
    'current_location_id',
    'destination_location_id',
    'created_by',
])]
class Shipment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_IN_TRANSIT = 'in_transit';

    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_DELAYED = 'delayed';

    public const STATUS_ON_HOLD = 'on_hold';

    public const SHIPPING_METHOD_AIR = 'air';

    public const SHIPPING_METHOD_SEA = 'sea';

    public const SHIPPING_METHOD_EXPRESS = 'express';

    protected function casts(): array
    {
        return [
            'estimated_delivery_date' => 'date',
            'dispatch_date' => 'date',
            'parcel_weight' => 'decimal:2',
            'parcel_value' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Shipment $shipment) {
            if (! filled($shipment->tracking_id)) {
                $shipment->tracking_id = static::generateTrackingId();
            }

            if (! filled($shipment->status)) {
                $shipment->status = self::STATUS_PENDING;
            }
        });
    }

    public static function generateTrackingId(): string
    {
        do {
            $candidate = 'FSH-'.Str::upper(Str::random(6));
        } while (static::query()->where('tracking_id', $candidate)->exists());

        return $candidate;
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'origin_location_id');
    }

    public function current(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'current_location_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_location_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(TrackingEvent::class)->orderBy('occurred_at')->orderBy('sequence');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
