<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scholarship extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'min_gpa',
        'quota',
        'remaining_quota',
        'open_date',
        'close_date',
        'status',
    ];

    protected $casts = [
        'open_date' => 'date',
        'close_date' => 'date',
        'min_gpa' => 'decimal:2',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(ScholarshipApplication::class);
    }
}