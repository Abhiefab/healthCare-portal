<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        abort_if($request->user()?->role !== 'doctor', 403);

        $doctor = $request->user()->load('doctorProfile');

        if (! $doctor->doctorProfile) {
            $doctor->doctorProfile()->create([
                'title' => 'Doctor',
                'status' => 'Available',
            ]);

            $doctor->load('doctorProfile');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:70'],
            'status' => ['required', 'string', 'in:Available,Busy,Offline'],
            'location' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
        ]);

        $doctor->doctorProfile->update($validated);

        return back()->with('status', 'Profile updated successfully.');
    }
}
