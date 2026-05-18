@extends('layouts.admin')

@section('title', 'Doctor Dashboard')

@section('content')
@php
    $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
@endphp

<div class="admin-dashboard">
    <aside class="sidebar">
        <div>
            <div class="sidebar-logo">
                <i class="ri-heart-pulse-fill"></i>
                <span>MediCare</span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('doctor.dashboard') }}" class="nav-item active">
                    <i class="ri-home-5-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('doctors', ['from' => 'doctor']) }}" class="nav-item">
                    <i class="ri-user-star-line"></i>
                    <span>Directory</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr($doctor->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <h4>{{ $doctor->name }}</h4>
                <p>{{ $profile->title }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-form">
                @csrf
                <button type="submit" title="Logout">
                    <i class="ri-logout-box-r-line"></i>
                </button>
            </form>
        </div>
    </aside>

    <main class="dashboard-main">
        <header class="dashboard-topbar">
            <div>
                <h1>Doctor Dashboard</h1>
                <p>Welcome back, {{ $doctor->name }}. Your profile is connected to the doctor directory.</p>
            </div>
            <div class="topbar-right">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-action" type="submit">
                        <i class="ri-logout-box-r-line"></i>
                        Logout
                    </button>
                </form>
                <div class="profile-avatar">{{ strtoupper(substr($doctor->name, 0, 1)) }}</div>
            </div>
        </header>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="ri-stethoscope-line"></i></div>
                <div>
                    <p>Availability</p>
                    <h2 class="stat-text">{{ $profile->status }}</h2>
                    <span>{{ $profile->specialization ?: 'General Practice' }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="ri-calendar-event-line"></i></div>
                <div>
                    <p>Today</p>
                    <h2>{{ $todayAppointments }}</h2>
                    <span>Appointments</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="ri-group-line"></i></div>
                <div>
                    <p>Pending Requests</p>
                    <h2>{{ $pendingAppointments }}</h2>
                    <span>Need review</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple"><i class="ri-user-star-line"></i></div>
                <div>
                    <p>Completed Visits</p>
                    <h2>{{ $completedAppointments }}</h2>
                    <span>Care delivered</span>
                </div>
            </div>
        </section>

        <section class="profile-panel">
            <div class="profile-media">
                @if ($profile->image_path)
                    <img src="{{ asset($profile->image_path) }}" alt="{{ $doctor->name }}">
                @else
                    <div class="profile-placeholder">{{ strtoupper(substr($doctor->name, 0, 1)) }}</div>
                @endif
            </div>
            <div>
                <p class="eyebrow">Your Public Profile</p>
                <h2>{{ $doctor->name }}</h2>
                <p>{{ $profile->title }} at {{ $profile->location ?: 'location not set' }}</p>
                <div class="profile-tags">
                    <span>{{ $profile->experience_years }}+ years</span>
                    <span>{{ $profile->status }}</span>
                    <span>{{ $profile->specialization ?: 'General Practice' }}</span>
                    <span>{{ number_format($profile->rating, 1) }} rating</span>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Availability & Profile</h2>
                <div class="table-actions">
                    <a href="{{ route('doctors', ['from' => 'doctor']) }}" class="filter-btn">
                        <i class="ri-eye-line"></i>
                        View Public Profile
                    </a>
                </div>
            </div>

            <form class="doctor-form" method="POST" action="{{ route('doctor.profile.update') }}">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <label>
                        <span>Availability</span>
                        <select name="status" required>
                            @foreach (['Available', 'Busy', 'Offline'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $profile->status) === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Title</span>
                        <input name="title" value="{{ old('title', $profile->title) }}" required>
                    </label>
                    <label>
                        <span>Specialization</span>
                        <input name="specialization" value="{{ old('specialization', $profile->specialization) }}" placeholder="General Medicine">
                    </label>
                    <label>
                        <span>Experience Years</span>
                        <input type="number" min="0" max="70" name="experience_years" value="{{ old('experience_years', $profile->experience_years) }}" required>
                    </label>
                    <label>
                        <span>Location</span>
                        <input name="location" value="{{ old('location', $profile->location) }}" placeholder="Clinic or hospital">
                    </label>
                    <label>
                        <span>Image Path</span>
                        <input name="image_path" value="{{ old('image_path', $profile->image_path) }}" placeholder="images/doctors/doctor5.png">
                    </label>
                </div>
                <button class="add-btn" type="submit">
                    <i class="ri-save-line"></i>
                    Save Profile
                </button>
            </form>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Weekly Availability</h2>
            </div>

            <form class="doctor-form" method="POST" action="{{ route('doctor.availability.store') }}">
                @csrf
                <div class="form-grid">
                    <label>
                        <span>Day</span>
                        <select name="day_of_week" required>
                            @foreach ($dayNames as $index => $dayName)
                                <option value="{{ $index }}">{{ $dayName }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Starts</span>
                        <input type="time" name="starts_at" required>
                    </label>
                    <label>
                        <span>Ends</span>
                        <input type="time" name="ends_at" required>
                    </label>
                </div>
                <button class="add-btn" type="submit">
                    <i class="ri-add-line"></i>
                    Add Slot
                </button>
            </form>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($availabilitySlots as $slot)
                            <tr>
                                <td>{{ $dayNames[$slot->day_of_week] }}</td>
                                <td>{{ \Carbon\Carbon::parse($slot->starts_at)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->ends_at)->format('h:i A') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('doctor.availability.destroy', $slot) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="danger-btn" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">No weekly slots added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Patient Appointments</h2>
                <div class="table-actions">
                    <a href="{{ route('doctors', ['from' => 'doctor']) }}" class="filter-btn">
                        <i class="ri-user-search-line"></i>
                        Browse Directory
                    </a>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->name }}</td>
                                <td>{{ $appointment->appointment_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $appointment->reason ?: 'General consultation' }}</td>
                                <td><span class="status {{ strtolower($appointment->status) }}">{{ $appointment->status }}</span></td>
                                <td>
                                    @if ($appointment->reschedule_requested_at)
                                        <div class="request-note">
                                            Requested: {{ $appointment->reschedule_requested_at->format('M d, Y h:i A') }}
                                            @if ($appointment->reschedule_reason)
                                                <span>{{ $appointment->reschedule_reason }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    <form class="status-form" method="POST" action="{{ route('appointments.update', $appointment) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="status">
                                            @foreach (['Pending', 'Confirmed', 'Completed', 'Cancelled'] as $status)
                                                <option value="{{ $status }}" @selected($appointment->status === $status)>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        @if ($appointment->reschedule_requested_at)
                                            <input type="hidden" name="appointment_at" value="{{ $appointment->reschedule_requested_at->format('Y-m-d H:i:s') }}">
                                        @endif
                                        <input name="notes" value="{{ $appointment->notes }}" placeholder="Notes">
                                        <input name="prescription" value="{{ $appointment->prescription }}" placeholder="Prescription">
                                        <button class="add-btn" type="submit">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No appointment requests yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@endsection
