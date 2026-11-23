<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SemesterEvaluation extends Model
{
    protected $fillable = [
        'user_id',
        'scholarship_id',
        'semester_ke',
        'ips_score',
        'ipk_score',
        'khs_file',
        'verification_status',
        'ews_status',
        'evaluator_notes',
    ];

    protected $casts = [
        'semester_ke' => 'integer',
        'ips_score' => 'decimal:2',
        'ipk_score' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }
}