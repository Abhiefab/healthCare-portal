<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function admin(): View
    {
        $this->authorizeRole('admin');

        $doctors = $this->doctorQuery()->orderBy('users.name')->get();

        return view('admin.dashboard', [
            'doctors' => $doctors,
            'appointments' => Appointment::with(['patient', 'doctorProfile.user'])->latest('appointment_at')->limit(8)->get(),
            'totalDoctors' => User::where('role', 'doctor')->count(),
            'totalPatients' => User::where('role', 'patient')->count(),
            'totalUsers' => User::count(),
            'pendingAppointments' => Appointment::where('status', 'Pending')->count(),
            'averageRating' => round((float) DoctorProfile::avg('rating'), 1),
        ]);
    }

    public function doctor(Request $request): View
    {
        $this->authorizeRole('doctor');

        $doctor = $request->user()->load('doctorProfile');

        if (! $doctor->doctorProfile) {
            $doctor->doctorProfile()->create([
                'title' => 'Doctor',
                'status' => 'Available',
            ]);
            $doctor->load('doctorProfile');
        }

        return view('doctor.dashboard', [
            'doctor' => $doctor,
            'profile' => $doctor->doctorProfile,
            'appointments' => $doctor->doctorProfile->appointments()
                ->with('patient')
                ->latest('appointment_at')
                ->get(),
            'pendingAppointments' => $doctor->doctorProfile->appointments()->where('status', 'Pending')->count(),
            'confirmedAppointments' => $doctor->doctorProfile->appointments()->where('status', 'Confirmed')->count(),
            'totalDoctors' => User::where('role', 'doctor')->count(),
            'totalPatients' => User::where('role', 'patient')->count(),
            'topDoctors' => $this->doctorQuery()->orderByDesc('doctor_profiles.rating')->limit(5)->get(),
        ]);
    }

    public function patient(Request $request): View
    {
        $this->authorizeRole('patient');

        $doctors = $this->doctorQuery()->orderByDesc('doctor_profiles.rating')->get();

        return view('patient.dashboard', [
            'patient' => $request->user(),
            'doctors' => $doctors,
            'appointments' => $request->user()->patientAppointments()
                ->with('doctorProfile.user')
                ->latest('appointment_at')
                ->get(),
            'upcomingAppointments' => $request->user()->patientAppointments()
                ->whereIn('status', ['Pending', 'Confirmed'])
                ->where('appointment_at', '>=', now())
                ->count(),
            'availableDoctors' => $doctors->where('status', 'Available')->count(),
            'specialtyCount' => $doctors->pluck('specialization')->filter()->unique()->count(),
            'topRating' => $doctors->max('rating') ?: 0,
        ]);
    }

    private function doctorQuery()
    {
        return DoctorProfile::query()
            ->with('user')
            ->join('users', 'users.id', '=', 'doctor_profiles.user_id')
            ->where('users.role', 'doctor')
            ->select('doctor_profiles.*');
    }

    private function authorizeRole(string $role): void
    {
        abort_if(auth()->user()?->role !== $role, 403);
    }
}
