<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'in:Available,Busy,Offline'],
            'from' => ['nullable', 'string', 'in:admin,doctor,patient'],
        ]);

        $doctors = DoctorProfile::query()
            ->with('user')
            ->whereHas('user', fn ($query) => $query->where('role', 'doctor'))
            ->when($filters['q'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('specialization', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['specialization'] ?? null, fn ($query, string $specialization) => $query->where('specialization', $specialization))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->orderByDesc('rating')
            ->orderBy('specialization')
            ->get();

        return view('doctors.index', [
            'doctors' => $doctors,
            'specializations' => DoctorProfile::query()
                ->whereHas('user', fn ($query) => $query->where('role', 'doctor'))
                ->whereNotNull('specialization')
                ->distinct()
                ->orderBy('specialization')
                ->pluck('specialization'),
            'filters' => $filters,
        ]);
    }
}
