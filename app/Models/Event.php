<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'event_time',
        'status',
        'is_archived',
        'allocated_budget',
    ];

    protected $casts = [
        'event_date'       => 'date',
        'allocated_budget' => 'decimal:2',
    ];

    public function attendees()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function donations()
    {
        return $this->hasMany(EventDonation::class);
    }

    public function getTotalEventDonatedAttribute(): float
    {
        return (float) $this->donations()->sum('amount');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'upcoming'  => 'bg-blue-100 text-blue-700',
            'ongoing'   => 'bg-green-100 text-green-700',
            'completed' => 'bg-gray-100 text-gray-600',
            'cancelled' => 'bg-red-100 text-red-700',
            default     => 'bg-gray-100 text-gray-600',
        };
    }
}