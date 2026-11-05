<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniTracer extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'city',
        'waiting_months',
        'ready_for_sharing',
        'contact_linkedin',
    ];

    protected $casts = [
        'waiting_months' => 'integer',
        'ready_for_sharing' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
