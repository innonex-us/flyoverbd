<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tour_id',
        'booking_reference',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'number_of_participants',
        'participants',
        'travel_date',
        'total_amount',
        'paid_amount',
        'currency',
        'payment_status',
        'booking_status',
        'special_requests',
        'admin_notes',
        'assigned_to',
        'confirmed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'participants' => 'array',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'number_of_participants' => 'integer',
        'travel_date' => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'BK' . strtoupper(Str::random(8));
            }
        });
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
