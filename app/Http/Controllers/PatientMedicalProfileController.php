<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PatientMedicalProfileController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        abort_if($request->user()?->role !== 'patient', 403);

        $validated = $request->validate([
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'gender' => ['nullable', 'string', 'max:50'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'emergency_contact' => ['nullable', 'string', 'max:100'],
            'allergies' => ['nullable', 'string', 'max:1000'],
            'conditions' => ['nullable', 'string', 'max:1000'],
            'medications' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->user()->medicalProfile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated,
        );

        return back()->with('status', 'Medical profile updated.');
    }
}
