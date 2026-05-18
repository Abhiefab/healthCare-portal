<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientMedicalProfile extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'blood_group',
        'emergency_contact',
        'allergies',
        'conditions',
        'medications',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
