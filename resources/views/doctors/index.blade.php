@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
<link rel="stylesheet" href="{{ asset('css/doctors.css') }}">
@endpush

@section('title', 'Doctors - Medicom')

@section('content')
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
            </div>
            <div class="hero-image"></div>
        </div>

        <div class="filter-wrapper">
            <div class="search-box">
                <i class="ri-search-line"></i>
                <input type="text" placeholder="Search doctor by name, specialty or keyword...">
            </div>

            <div class="filter-select">
                <select>
                    <option>All Specialties</option>
                    @foreach ($specializations as $specialization)
                        <option>{{ $specialization }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-select">
                <select>
                    <option>Availability</option>
                    <option>Available</option>
                    <option>Busy</option>
                    <option>Offline</option>
                </select>
            </div>

            <button class="filter-btn">
                <i class="ri-equalizer-line"></i>
                Filter
            </button>
        </div>

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

                        <div class="doctor-actions">
                            <a href="{{ auth()->check() ? route(auth()->user()->role === 'doctor' ? 'doctor.dashboard' : (auth()->user()->role === 'admin' ? 'admin.dashboard' : 'patient.dashboard')) : route('login') }}" class="profile-btn">
                                View Profile
                            </a>
                            <a href="{{ auth()->check() ? route(auth()->user()->role === 'patient' ? 'patient.dashboard' : (auth()->user()->role === 'admin' ? 'admin.dashboard' : 'doctor.dashboard')) : route('login') }}" class="appointment-btn">
                                <i class="ri-calendar-line"></i>
                            </a>
                        </div>
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
