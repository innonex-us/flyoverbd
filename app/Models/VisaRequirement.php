<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VisaRequirement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country',
        'country_code',
        'slug',
        'description',
        'required_documents',
        'application_guidelines',
        'processing_time',
        'visa_fee',
        'currency',
        'eligibility_criteria',
        'important_notes',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'required_documents' => 'array',
        'visa_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($visa) {
            if (empty($visa->slug)) {
                $visa->slug = Str::slug($visa->country);
            }
        });

        static::updating(function ($visa) {
            if ($visa->isDirty('country') && empty($visa->slug)) {
                $visa->slug = Str::slug($visa->country);
            }
        });
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'visa_requirement_id');
    }
}
