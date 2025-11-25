<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportLike extends Model
{
    protected $fillable = [
        'report_id',
        'user_id',
    ];

    /**
     * The report that was liked.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * The user who liked the report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

