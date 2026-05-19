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
                <a href="{{ route('doctors', ['from' => 'patient']) }}" class="nav-item">
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
                <h1>Patient Dashboard</h1>
                <p>Find available doctors and compare specialists from the live directory.</p>
            </div>
            <div class="topbar-right">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-action" type="submit">
                        <i class="ri-logout-box-r-line"></i>
                        Logout
                    </button>
                </form>
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
                    <p>Pending Requests</p>
                    <h2>{{ $pendingAppointments }}</h2>
                    <span>Waiting for confirmation</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="ri-star-line"></i></div>
                <div>
                    <p>Completed Visits</p>
                    <h2>{{ $completedAppointments }}</h2>
                    <span>Consultations finished</span>
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

        <section class="profile-panel">
            <div class="profile-media profile-placeholder">
                {{ strtoupper(substr($patient->name, 0, 1)) }}
            </div>
            <div>
                <p class="eyebrow">Care Overview</p>
                <h2>{{ $patient->name }}</h2>
                <p>Track appointments, compare available doctors, and manage visit requests from one place.</p>
                <div class="profile-tags">
                    <span>{{ $specialtyCount }} specialties</span>
                    <span>{{ number_format($topRating, 1) }} top rating</span>
                    <span>{{ $cancelledAppointments }} cancelled</span>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('doctors', ['from' => 'patient', 'status' => 'Available']) }}" class="add-btn">
                        <i class="ri-calendar-check-line"></i>
                        Book Available Doctor
                    </a>
                    <a href="{{ route('doctors', ['from' => 'patient']) }}" class="filter-btn">
                        <i class="ri-search-line"></i>
                        Compare Doctors
                    </a>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Medical Profile</h2>
            </div>

            <form class="doctor-form" method="POST" action="{{ route('patient.medical-profile.update') }}">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <label>
                        <span>Age</span>
                        <input type="number" min="0" max="120" name="age" value="{{ old('age', $medicalProfile?->age) }}">
                    </label>
                    <label>
                        <span>Gender</span>
                        <input name="gender" value="{{ old('gender', $medicalProfile?->gender) }}" placeholder="Optional">
                    </label>
                    <label>
                        <span>Blood Group</span>
                        <input name="blood_group" value="{{ old('blood_group', $medicalProfile?->blood_group) }}" placeholder="O+">
                    </label>
                    <label>
                        <span>Emergency Contact</span>
                        <input name="emergency_contact" value="{{ old('emergency_contact', $medicalProfile?->emergency_contact) }}">
                    </label>
                    <label>
                        <span>Allergies</span>
                        <input name="allergies" value="{{ old('allergies', $medicalProfile?->allergies) }}" placeholder="None">
                    </label>
                    <label>
                        <span>Conditions</span>
                        <input name="conditions" value="{{ old('conditions', $medicalProfile?->conditions) }}" placeholder="Diabetes, asthma...">
                    </label>
                    <label>
                        <span>Current Medications</span>
                        <input name="medications" value="{{ old('medications', $medicalProfile?->medications) }}" placeholder="Medication names">
                    </label>
                </div>
                <button class="add-btn" type="submit">
                    <i class="ri-save-line"></i>
                    Save Medical Profile
                </button>
            </form>
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
                                <td>
                                    {{ $appointment->reason ?: 'General consultation' }}
                                    @if ($appointment->reschedule_requested_at)
                                        <div class="request-note">
                                            Reschedule requested for {{ $appointment->reschedule_requested_at->format('M d, Y h:i A') }}
                                        </div>
                                    @endif
                                    @if ($appointment->prescription)
                                        <div class="request-note">
                                            Prescription: {{ $appointment->prescription }}
                                        </div>
                                    @endif
                                </td>
                                <td><span class="status {{ strtolower($appointment->status) }}">{{ $appointment->status }}</span></td>
                                <td>
                                    @if ($appointment->status !== 'Cancelled' && $appointment->status !== 'Completed')
                                        <form class="inline-booking-form" method="POST" action="{{ route('appointments.update', $appointment) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="datetime-local" name="reschedule_requested_at" required>
                                            <input name="reschedule_reason" placeholder="Reason for new time">
                                            <button class="add-btn" type="submit">Reschedule</button>
                                        </form>
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
                    <a href="{{ route('doctors', ['from' => 'patient']) }}" class="filter-btn">
                        <i class="ri-search-line"></i>
                        Browse All
                    </a>
                    <a href="{{ route('doctors', ['from' => 'patient', 'status' => 'Available']) }}" class="filter-btn">
                        <i class="ri-calendar-check-line"></i>
                        Available
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
