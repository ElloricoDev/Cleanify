<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'area',
        'days',
        'time_start',
        'time_end',
        'truck',
        'status',
    ];

    protected $casts = [
        'time_start' => 'datetime',
        'time_end' => 'datetime',
    ];

    /**
     * Get the formatted time range.
     */
    public function getTimeRangeAttribute(): string
    {
        $start = $this->time_start instanceof \DateTime ? $this->time_start : new \DateTime($this->time_start);
        $end = $this->time_end instanceof \DateTime ? $this->time_end : new \DateTime($this->time_end);
        return $start->format('g:i A') . ' - ' . $end->format('g:i A');
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'inactive' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute(): string
    {
        return ucfirst($this->status);
    }
}
