<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TourPackage extends Model
{
    use SoftDeletes;

    protected $table = 'tours';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'itinerary',
        'highlights',
        'images',
        'thumbnail',
        'price',
        'currency',
        'duration_days',
        'destination',
        'departure_location',
        'start_date',
        'end_date',
        'max_participants',
        'min_participants',
        'is_featured',
        'is_active',
        'included',
        'excluded',
        'terms_conditions',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'max_participants' => 'integer',
        'min_participants' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            if (empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });

        static::updating(function ($tour) {
            if ($tour->isDirty('title') && empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'tour_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'tour_id');
    }
}
