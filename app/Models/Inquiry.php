<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'type',
        'tour_id',
        'visa_requirement_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'admin_notes',
        'assigned_to',
        'contacted_at',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_id');
    }

    public function visaRequirement(): BelongsTo
    {
        return $this->belongsTo(VisaRequirement::class, 'visa_requirement_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
