<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TruckLocation extends Model
{
    protected $fillable = [
        'truck_id',
        'latitude',
        'longitude',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the truck that owns this location.
     */
    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }
}
