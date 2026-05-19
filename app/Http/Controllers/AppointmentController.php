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
            'return_to' => ['nullable', 'url'],
        ]);

        $request->user()->patientAppointments()->create([
            'doctor_profile_id' => $doctor->id,
            'appointment_at' => $validated['appointment_at'],
            'reason' => $validated['reason'] ?? null,
            'status' => 'Pending',
        ]);

        if (! empty($validated['return_to']) && $this->isSameHostUrl($validated['return_to'], $request)) {
            return redirect()->to($validated['return_to'])->with('status', 'Appointment request sent.');
        }

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
            'status' => ['nullable', Rule::in($allowed)],
            'notes' => ['nullable', 'string', 'max:1000'],
            'prescription' => ['nullable', 'string', 'max:2000'],
            'appointment_at' => ['nullable', 'date', 'after:now'],
            'reschedule_requested_at' => ['nullable', 'date', 'after:now'],
            'reschedule_reason' => ['nullable', 'string', 'max:500'],
        ]);

        if ($user->role === 'patient') {
            if (! empty($validated['reschedule_requested_at'])) {
                $appointment->update([
                    'reschedule_requested_at' => $validated['reschedule_requested_at'],
                    'reschedule_reason' => $validated['reschedule_reason'] ?? null,
                    'status' => 'Pending',
                ]);

                return back()->with('status', 'Reschedule request sent.');
            }

            abort_if(($validated['status'] ?? null) !== 'Cancelled', 403);

            $appointment->update([
                'status' => 'Cancelled',
            ]);

            return back()->with('status', 'Appointment cancelled.');
        }

        $appointment->update([
            'status' => $validated['status'] ?? $appointment->status,
            'appointment_at' => $validated['appointment_at'] ?? $appointment->appointment_at,
            'reschedule_requested_at' => ! empty($validated['appointment_at']) ? null : $appointment->reschedule_requested_at,
            'reschedule_reason' => ! empty($validated['appointment_at']) ? null : $appointment->reschedule_reason,
            'notes' => $validated['notes'] ?? $appointment->notes,
            'prescription' => $validated['prescription'] ?? $appointment->prescription,
        ]);

        return back()->with('status', 'Appointment updated.');
    }

    private function isSameHostUrl(string $url, Request $request): bool
    {
        $parts = parse_url($url);

        return ($parts['scheme'] ?? null) === $request->getScheme()
            && ($parts['host'] ?? null) === $request->getHost()
            && (int) ($parts['port'] ?? $request->getPort()) === $request->getPort();
    }
}
