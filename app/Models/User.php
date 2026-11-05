<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'nim_nip',
    'major',
    'academic_status',
    'is_awardee',
    'dosen_pa_id',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function academicAdvisor(): BelongsTo
    {
        return $this->belongsTo(self::class, 'dosen_pa_id');
    }

    public function advisees(): HasMany
    {
        return $this->hasMany(self::class, 'dosen_pa_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_awardee' => 'boolean',
        ];
    }
}
