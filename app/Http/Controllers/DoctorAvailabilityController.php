<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DoctorAvailabilityController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        abort_if($request->user()?->role !== 'doctor', 403);

        $doctor = $request->user()->load('doctorProfile');
        abort_if(! $doctor->doctorProfile, 404);

        $validated = $request->validate([
            'day_of_week' => ['required', 'integer', 'min:0', 'max:6'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['required', 'date_format:H:i', 'after:starts_at'],
        ]);

        $doctor->doctorProfile->availabilities()->create($validated + [
            'is_active' => true,
        ]);

        return back()->with('status', 'Availability slot added.');
    }

    public function destroy(Request $request, int $availability): RedirectResponse
    {
        abort_if($request->user()?->role !== 'doctor', 403);

        $profile = $request->user()->doctorProfile;
        abort_if(! $profile, 404);

        $slot = $profile->availabilities()
            ->whereKey($availability)
            ->firstOrFail();

        $slot->delete();

        return back()->with('status', 'Availability slot removed.');
    }
}
