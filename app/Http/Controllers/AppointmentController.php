<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function store(Request $request, DoctorProfile $doctor): RedirectResponse
    {
        abort_if($request->user()->role !== 'patient', 403);

        $validated = $request->validate([
            'appointment_at' => ['required', 'date', 'after:now'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $request->user()->patientAppointments()->create([
            'doctor_profile_id' => $doctor->id,
            'appointment_at' => $validated['appointment_at'],
            'reason' => $validated['reason'] ?? null,
            'status' => 'Pending',
        ]);

        return redirect()->route('patient.dashboard')->with('status', 'Appointment request sent.');
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $user = $request->user();
        $allowed = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];

        abort_if(! in_array($user->role, ['admin', 'doctor', 'patient'], true), 403);
        abort_if($user->role === 'patient' && $appointment->patient_id !== $user->id, 403);
        abort_if($user->role === 'doctor' && $appointment->doctorProfile?->user_id !== $user->id, 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in($allowed)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($user->role === 'patient') {
            abort_if($validated['status'] !== 'Cancelled', 403);
        }

        $appointment->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $appointment->notes,
        ]);

        return back()->with('status', 'Appointment updated.');
    }
}
