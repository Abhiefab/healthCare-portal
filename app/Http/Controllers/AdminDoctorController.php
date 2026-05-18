<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminDoctorController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $this->validateDoctor($request);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Str::password(12),
                'role' => 'doctor',
            ]);

            $user->doctorProfile()->create($this->profileData($validated));
        });

        return redirect()->route('admin.dashboard')->with('status', 'Doctor added successfully.');
    }

    public function update(Request $request, DoctorProfile $doctor): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $this->validateDoctor($request, $doctor);

        DB::transaction(function () use ($doctor, $validated) {
            $doctor->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $doctor->update($this->profileData($validated));
        });

        return redirect()->route('admin.dashboard')->with('status', 'Doctor updated successfully.');
    }

    public function destroy(DoctorProfile $doctor): RedirectResponse
    {
        $this->authorizeAdmin();

        $doctor->user->delete();

        return redirect()->route('admin.dashboard')->with('status', 'Doctor removed successfully.');
    }

    private function validateDoctor(Request $request, ?DoctorProfile $doctor = null): array
    {
        $userId = $doctor?->user_id;

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'title' => ['required', 'string', 'max:100'],
            'specialization' => ['required', 'string', 'max:100'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:70'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'review_count' => ['required', 'integer', 'min:0', 'max:100000'],
            'status' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function profileData(array $validated): array
    {
        return [
            'title' => $validated['title'],
            'specialization' => $validated['specialization'],
            'experience_years' => $validated['experience_years'],
            'rating' => $validated['rating'],
            'review_count' => $validated['review_count'],
            'status' => $validated['status'],
            'location' => $validated['location'],
            'image_path' => $validated['image_path'] ?? null,
        ];
    }

    private function authorizeAdmin(): void
    {
        abort_if(auth()->user()?->role !== 'admin', 403);
    }
}
