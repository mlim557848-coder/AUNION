<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBudgetAllocation extends Model
{
    protected $fillable = [
        'event_id',
        'amount',
        'note',
        'allocated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function allocatedBy()
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }
}