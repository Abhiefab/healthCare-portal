<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(): View
    {
        return view('doctors.index', [
            'doctors' => DoctorProfile::with('user')
                ->whereHas('user', fn ($query) => $query->where('role', 'doctor'))
                ->orderByDesc('rating')
                ->orderBy('specialization')
                ->get(),
            'specializations' => DoctorProfile::query()
                ->whereNotNull('specialization')
                ->distinct()
                ->orderBy('specialization')
                ->pluck('specialization'),
        ]);
    }
}
