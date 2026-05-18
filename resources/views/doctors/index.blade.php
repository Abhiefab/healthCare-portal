@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
<link rel="stylesheet" href="{{ asset('css/doctors.css') }}">
@endpush

@section('title', 'Doctors - Medicom')

@section('content')
@php
    $user = auth()->user();
    $role = $user?->role;
    $dashboardRoute = match ($role) {
        'admin' => 'admin.dashboard',
        'doctor' => 'doctor.dashboard',
        'patient' => 'patient.dashboard',
        default => null,
    };
    $dashboardLabel = match ($role) {
        'admin' => 'Admin Dashboard',
        'doctor' => 'Doctor Dashboard',
        'patient' => 'Patient Dashboard',
        default => 'Dashboard',
    };
    $from = ($filters['from'] ?? null) === $role ? $role : null;
@endphp

<section class="doctors-page">
    <div class="container">
        <div class="doctors-hero">
            <div class="hero-content">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="ri-arrow-right-s-line"></i>
                    <span>Doctors</span>
                </div>
                <h1>All Doctors</h1>
                <p>Browse experienced and qualified doctors across multiple specialties and healthcare departments.</p>

                @if ($dashboardRoute && $from)
                    <a href="{{ route($dashboardRoute) }}" class="dashboard-back-btn">
                        <i class="ri-arrow-left-line"></i>
                        Back to {{ $dashboardLabel }}
                    </a>
                @endif
            </div>
            <div class="hero-image"></div>
        </div>

        @if (session('status'))
            <div class="directory-alert success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="directory-alert error">{{ $errors->first() }}</div>
        @endif

        <form class="filter-wrapper" method="GET" action="{{ route('doctors') }}">
            @if ($from)
                <input type="hidden" name="from" value="{{ $from }}">
            @endif

            <div class="search-box">
                <i class="ri-search-line"></i>
                <input
                    type="text"
                    name="q"
                    value="{{ $filters['q'] ?? '' }}"
                    placeholder="Search doctor by name, specialty or keyword..."
                >
            </div>

            <div class="filter-select">
                <select name="specialization">
                    <option value="">All Specialties</option>
                    @foreach ($specializations as $specialization)
                        <option value="{{ $specialization }}" @selected(($filters['specialization'] ?? '') === $specialization)>
                            {{ $specialization }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-select">
                <select name="status">
                    <option value="">Availability</option>
                    @foreach (['Available', 'Busy', 'Offline'] as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <button class="filter-btn" type="submit">
                <i class="ri-equalizer-line"></i>
                Filter
            </button>

            <a href="{{ route('doctors', $from ? ['from' => $from] : []) }}" class="reset-btn">
                Reset
            </a>
        </form>

        <div class="doctors-grid">
            @forelse ($doctors as $doctor)
                <div class="doctor-card">
                    <div class="doctor-image">
                        @if ($doctor->image_path)
                            <img src="{{ asset($doctor->image_path) }}" alt="{{ $doctor->user->name }}">
                        @else
                            <div class="doctor-image-fallback">{{ strtoupper(substr($doctor->user->name, 0, 1)) }}</div>
                        @endif
                    </div>

                    <div class="doctor-info">
                        <div class="doctor-status">
                            <span></span>
                            {{ $doctor->status }}
                        </div>

                        <h3>{{ $doctor->user->name }}</h3>
                        <h5>{{ $doctor->title }}</h5>

                        <div class="doctor-meta">
                            <p>
                                <i class="ri-star-fill"></i>
                                {{ number_format($doctor->rating, 1) }} ({{ $doctor->review_count }} reviews)
                            </p>
                            <p>
                                <i class="ri-map-pin-line"></i>
                                {{ $doctor->location }}
                            </p>
                            <p>
                                <i class="ri-briefcase-line"></i>
                                {{ $doctor->experience_years }}+ years experience
                            </p>
                        </div>

                        @if (($dashboardRoute && $from) || $role === 'patient' || ! $role)
                            <div class="doctor-actions">
                                @if ($dashboardRoute && $from)
                                    <a href="{{ route($dashboardRoute) }}" class="profile-btn">
                                        Dashboard
                                    </a>
                                @elseif (! $role)
                                    <a href="{{ route('login') }}" class="profile-btn">
                                        Book Appointment
                                    </a>
                                @endif

                                @if ($role === 'patient')
                                    <details class="card-booking">
                                        <summary class="appointment-btn" title="Book appointment">
                                            <i class="ri-calendar-line"></i>
                                        </summary>
                                        <form method="POST" action="{{ route('appointments.store', $doctor) }}">
                                            @csrf
                                            <input type="hidden" name="return_to" value="{{ request()->fullUrl() }}">
                                            <input type="datetime-local" name="appointment_at" required>
                                            <input name="reason" placeholder="Reason for visit">
                                            <button type="submit">Request</button>
                                        </form>
                                    </details>
                                @elseif (! $role)
                                    <a href="{{ route('login') }}" class="appointment-btn" title="Book appointment">
                                        <i class="ri-calendar-line"></i>
                                    </a>
                                @endif
                            </div>
                        @endif

                        @if ($role === 'patient')
                            <div class="patient-booking-note">
                                <i class="ri-calendar-line"></i>
                                Select a visit time from the calendar button.
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    No doctors are available yet. Please check back soon.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
