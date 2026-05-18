<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_profile_id',
        'appointment_at',
        'reschedule_requested_at',
        'reason',
        'reschedule_reason',
        'status',
        'notes',
        'prescription',
    ];

    protected function casts(): array
    {
        return [
            'appointment_at' => 'datetime',
            'reschedule_requested_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }
}
