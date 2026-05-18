@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">
    <aside class="sidebar">
        <div>
            <div class="sidebar-logo">
                <i class="ri-heart-pulse-fill"></i>
                <span>MediCare</span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                    <i class="ri-home-5-line"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('doctors') }}" class="nav-item">
                    <i class="ri-user-star-line"></i>
                    <span>Doctors</span>
                </a>
                <a href="#doctor-manager" class="nav-item">
                    <i class="ri-edit-2-line"></i>
                    <span>Manage</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <h4>{{ auth()->user()->name }}</h4>
                <p>Administrator</p>
            </div>
        </div>
    </aside>

    <main class="dashboard-main">
        <header class="dashboard-topbar">
            <div>
                <h1>Admin Dashboard</h1>
                <p>Manage doctors, patients, and the public doctor directory.</p>
            </div>
            <div class="topbar-right">
                <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            </div>
        </header>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="ri-user-star-line"></i></div>
                <div>
                    <p>Total Doctors</p>
                    <h2>{{ $totalDoctors }}</h2>
                    <span>DB connected</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="ri-group-line"></i></div>
                <div>
                    <p>Total Patients</p>
                    <h2>{{ $totalPatients }}</h2>
                    <span>Registered users</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple"><i class="ri-team-line"></i></div>
                <div>
                    <p>Pending Visits</p>
                    <h2>{{ $pendingAppointments }}</h2>
                    <span>Appointment requests</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="ri-star-line"></i></div>
                <div>
                    <p>Average Rating</p>
                    <h2>{{ number_format($averageRating, 1) }}</h2>
                    <span>Doctor profiles</span>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Appointments</h2>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->name }}</td>
                                <td>{{ $appointment->doctorProfile->user->name }}</td>
                                <td>{{ $appointment->appointment_at->format('M d, Y h:i A') }}</td>
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
                                        <button class="add-btn" type="submit">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No appointments have been requested yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="table-section" id="doctor-manager">
            <div class="table-header">
                <h2>Add Doctor</h2>
            </div>

            <form class="doctor-form" method="POST" action="{{ route('admin.doctors.store') }}">
                @csrf
                @include('admin.partials.doctor-form-fields', ['doctor' => null])
                <button class="add-btn" type="submit">
                    <i class="ri-add-line"></i>
                    Add Doctor
                </button>
            </form>
        </section>

        <section class="table-section">
            <div class="table-header">
                <h2>Doctors</h2>
                <div class="table-actions">
                    <a href="{{ route('doctors') }}" class="filter-btn">
                        <i class="ri-external-link-line"></i>
                        Public Page
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
                            <th>Manage</th>
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
                                        <summary><i class="ri-edit-line"></i> Edit</summary>
                                        <form class="doctor-form compact" method="POST" action="{{ route('admin.doctors.update', $doctor) }}">
                                            @csrf
                                            @method('PUT')
                                            @include('admin.partials.doctor-form-fields', ['doctor' => $doctor])
                                            <button class="add-btn" type="submit">Save</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.doctors.destroy', $doctor) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="danger-btn" type="submit">Delete Doctor</button>
                                        </form>
                                    </details>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">No doctors found. Add one above to publish the directory.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@endsection
