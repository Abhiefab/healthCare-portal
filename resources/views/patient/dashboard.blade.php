@extends('layouts.admin')

@section('title', 'Patient Dashboard')

@section('content')
<div class="admin-dashboard">
    <aside class="sidebar">
        <div>
            <div class="sidebar-logo">
                <i class="ri-heart-pulse-fill"></i>
                <span>MediCare</span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('patient.dashboard') }}" class="nav-item active">
                    <i class="ri-home-5-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('doctors') }}" class="nav-item">
                    <i class="ri-user-star-line"></i>
                    <span>Doctors</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr($patient->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <h4>{{ $patient->name }}</h4>
                <p>Patient</p>
            </div>
        </div>
    </aside>

    <main class="dashboard-main">
        <header class="dashboard-topbar">
            <div>
                <h1>Patient Dashboard</h1>
                <p>Find available doctors and compare specialists from the live directory.</p>
            </div>
            <div class="topbar-right">
                <div class="profile-avatar">{{ strtoupper(substr($patient->name, 0, 1)) }}</div>
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
                <div class="stat-icon blue"><i class="ri-user-heart-line"></i></div>
                <div>
                    <p>Available Doctors</p>
                    <h2>{{ $availableDoctors }}</h2>
                    <span>Ready for booking</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="ri-pulse-line"></i></div>
                <div>
                    <p>Specialties</p>
                    <h2>{{ $specialtyCount }}</h2>
                    <span>Across departments</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="ri-star-line"></i></div>
                <div>
                    <p>Top Rating</p>
                    <h2>{{ number_format($topRating, 1) }}</h2>
                    <span>Patient reviews</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple"><i class="ri-calendar-check-line"></i></div>
                <div>
                    <p>Upcoming Visits</p>
                    <h2>{{ $upcomingAppointments }}</h2>
                    <span>Pending or confirmed</span>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>My Appointments</h2>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->doctorProfile->user->name }}</td>
                                <td>{{ $appointment->appointment_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $appointment->reason ?: 'General consultation' }}</td>
                                <td><span class="status {{ strtolower($appointment->status) }}">{{ $appointment->status }}</span></td>
                                <td>
                                    @if ($appointment->status !== 'Cancelled' && $appointment->status !== 'Completed')
                                        <form method="POST" action="{{ route('appointments.update', $appointment) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Cancelled">
                                            <button class="danger-btn" type="submit">Cancel</button>
                                        </form>
                                    @else
                                        <span class="muted-text">No action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No appointments yet. Book one from the doctor list below.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Recommended Doctors</h2>
                <div class="table-actions">
                    <a href="{{ route('doctors') }}" class="filter-btn">
                        <i class="ri-search-line"></i>
                        Browse All
                    </a>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Experience</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Book</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctors as $doctor)
                            <tr>
                                <td>
                                    <div class="doctor-info">
                                        <div class="doctor-avatar">{{ collect(explode(' ', $doctor->user->name))->map(fn ($part) => substr($part, 0, 1))->take(2)->join('') }}</div>
                                        <div>
                                            <h4>{{ $doctor->user->name }}</h4>
                                            <p>{{ $doctor->title }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $doctor->specialization }}</td>
                                <td>{{ $doctor->experience_years }}+ years</td>
                                <td>{{ number_format($doctor->rating, 1) }} ({{ $doctor->review_count }})</td>
                                <td><span class="status active">{{ $doctor->status }}</span></td>
                                <td>
                                    <details class="manage-doctor">
                                        <summary><i class="ri-calendar-line"></i> Book</summary>
                                        <form class="inline-booking-form" method="POST" action="{{ route('appointments.store', $doctor) }}">
                                            @csrf
                                            <input type="datetime-local" name="appointment_at" required>
                                            <input name="reason" placeholder="Reason for visit">
                                            <button class="add-btn" type="submit">Request</button>
                                        </form>
                                    </details>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">No doctors are available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@endsection
