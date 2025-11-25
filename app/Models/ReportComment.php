<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportComment extends Model
{
    protected $fillable = [
        'report_id',
        'user_id',
        'comment',
    ];

    /**
     * Report this comment belongs to.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Comment author.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

