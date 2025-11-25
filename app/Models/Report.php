<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'location',
        'description',
        'image_path',
        'status',
        'admin_notes',
        'rejection_reason',
        'resolved_by',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the user who created the report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who resolved the report.
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the status badge color class.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'text-yellow-600',
            'resolved' => 'text-green-600',
            'rejected' => 'text-red-600',
            default => 'text-gray-600',
        };
    }

    /**
     * Get the status badge background class.
     */
    public function getStatusBadgeBgClass(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'resolved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Likes associated with this report.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ReportLike::class);
    }

    /**
     * Comments associated with this report.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ReportComment::class);
    }
}
