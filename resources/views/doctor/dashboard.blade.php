@extends('layouts.admin')

@section('title', 'Doctor Dashboard')

@section('content')
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
                <a href="{{ route('doctors') }}" class="nav-item">
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
        </div>
    </aside>

    <main class="dashboard-main">
        <header class="dashboard-topbar">
            <div>
                <h1>Doctor Dashboard</h1>
                <p>Welcome back, {{ $doctor->name }}. Your profile is connected to the doctor directory.</p>
            </div>
            <div class="topbar-right">
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
                    <p>Specialization</p>
                    <h2 class="stat-text">{{ $profile->specialization ?: 'Not set' }}</h2>
                    <span>{{ $profile->status }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="ri-star-line"></i></div>
                <div>
                    <p>Rating</p>
                    <h2>{{ number_format($profile->rating, 1) }}</h2>
                    <span>{{ $profile->review_count }} reviews</span>
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
                    <p>Confirmed Visits</p>
                    <h2>{{ $confirmedAppointments }}</h2>
                    <span>Scheduled</span>
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
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Patient Appointments</h2>
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
                                    <form class="status-form" method="POST" action="{{ route('appointments.update', $appointment) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="status">
                                            @foreach (['Pending', 'Confirmed', 'Completed', 'Cancelled'] as $status)
                                                <option value="{{ $status }}" @selected($appointment->status === $status)>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <input name="notes" value="{{ $appointment->notes }}" placeholder="Notes">
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
