@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="admin-dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">

        <div>

            <div class="sidebar-logo">
                <i class="ri-heart-pulse-fill"></i>
                <span>MediCare</span>
            </div>

            <nav class="sidebar-nav">

                <a href="#" class="nav-item active">
                    <i class="ri-home-5-line"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('doctors') }}" class="nav-item">
                    <i class="ri-user-star-line"></i>
                    <span>Doctors</span>
                </a>

                <a href="#" class="nav-item">
                    <i class="ri-calendar-check-line"></i>
                    <span>Appointments</span>
                </a>

                <a href="#" class="nav-item">
                    <i class="ri-group-line"></i>
                    <span>Patients</span>
                </a>

                <a href="#" class="nav-item">
                    <i class="ri-bar-chart-box-line"></i>
                    <span>Reports</span>
                </a>

            </nav>

        </div>

        <div class="sidebar-user">

            <div class="user-avatar">
                A
            </div>

            <div class="sidebar-user-info">
                <h4>Admin User</h4>
                <p>Super Admin</p>
            </div>

            <i class="ri-arrow-down-s-line"></i>

        </div>

    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">

        <!-- Topbar -->
        <header class="dashboard-topbar">

            <div>
                <h1>Dashboard</h1>
                <p>Welcome back, Admin! Here's what's happening.</p>
            </div>

            <div class="topbar-right">

                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="ri-search-line"></i>
                </div>

                <button class="notification-btn">
                    <i class="ri-notification-3-line"></i>
                </button>

                <div class="profile-avatar">
                    A
                </div>

            </div>

        </header>

        <!-- Stats -->
        <section class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon blue">
                    <i class="ri-user-star-line"></i>
                </div>

                <div>
                    <p>Total Doctors</p>
                    <h2>128</h2>
                    <span>↑ 12 this month</span>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon green">
                    <i class="ri-calendar-check-line"></i>
                </div>

                <div>
                    <p>Total Appointments</p>
                    <h2>1,256</h2>
                    <span>↑ 18 this month</span>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon purple">
                    <i class="ri-group-line"></i>
                </div>

                <div>
                    <p>Total Patients</p>
                    <h2>3,542</h2>
                    <span>↑ 25 this month</span>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-icon yellow">
                    <i class="ri-star-line"></i>
                </div>

                <div>
                    <p>Average Rating</p>
                    <h2>4.8</h2>
                    <span>↑ 0.2 this month</span>
                </div>

            </div>

        </section>

        <!-- Doctors Table -->
        <section class="table-section">

            <div class="table-header">

                <h2>Doctors</h2>

                <div class="table-actions">

                    <div class="table-search">
                        <input type="text" placeholder="Search doctors...">
                        <i class="ri-search-line"></i>
                    </div>

                    <button class="filter-btn">
                        <i class="ri-filter-3-line"></i>
                        Filter
                    </button>

                    <button class="add-btn">
                        <i class="ri-add-line"></i>
                        Add Doctor
                    </button>

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
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

    <tr>

        <td>
            <div class="doctor-info">

                <div class="doctor-avatar">MC</div>

                <div>
                    <h4>Dr. Michael Carter</h4>
                    <p>Orthopedic Surgeon</p>
                </div>

            </div>
        </td>

        <td>Orthopedics</td>
        <td>12+ years</td>
        <td>⭐ 4.9 (230)</td>

        <td>
            <span class="status active">
                ● Available
            </span>
        </td>

        <td>

            <div class="action-buttons">

                <button>
                    <i class="ri-eye-line"></i>
                </button>

                <button>
                    <i class="ri-delete-bin-line"></i>
                </button>

            </div>

        </td>

    </tr>


    <tr>

        <td>
            <div class="doctor-info">

                <div class="doctor-avatar">SJ</div>

                <div>
                    <h4>Dr. Sarah Johnson</h4>
                    <p>Pediatric Specialist</p>
                </div>

            </div>
        </td>

        <td>Pediatrics</td>
        <td>8+ years</td>
        <td>⭐ 4.8 (185)</td>

        <td>
            <span class="status active">
                ● Available
            </span>
        </td>

        <td>

            <div class="action-buttons">

                <button>
                    <i class="ri-eye-line"></i>
                </button>

                <button>
                    <i class="ri-delete-bin-line"></i>
                </button>

            </div>

        </td>

    </tr>


    <tr>

        <td>
            <div class="doctor-info">

                <div class="doctor-avatar">DW</div>

                <div>
                    <h4>Dr. David Wilson</h4>
                    <p>Cardiologist</p>
                </div>

            </div>
        </td>

        <td>Cardiology</td>
        <td>15+ years</td>
        <td>⭐ 4.9 (210)</td>

        <td>
            <span class="status active">
                ● Available
            </span>
        </td>

        <td>

            <div class="action-buttons">

                <button>
                    <i class="ri-eye-line"></i>
                </button>

                <button>
                    <i class="ri-delete-bin-line"></i>
                </button>

            </div>

        </td>

    </tr>


    <tr>

        <td>
            <div class="doctor-info">

                <div class="doctor-avatar">EB</div>

                <div>
                    <h4>Dr. Emily Brown</h4>
                    <p>Dermatologist</p>
                </div>

            </div>
        </td>

        <td>Dermatology</td>
        <td>9+ years</td>
        <td>⭐ 4.7 (160)</td>

        <td>
            <span class="status active">
                ● Available
            </span>
        </td>

        <td>

            <div class="action-buttons">

                <button>
                    <i class="ri-eye-line"></i>
                </button>

                <button>
                    <i class="ri-delete-bin-line"></i>
                </button>

            </div>

        </td>

    </tr>


    <tr>

        <td>
            <div class="doctor-info">

                <div class="doctor-avatar">OM</div>

                <div>
                    <h4>Dr. Olivia Martinez</h4>
                    <p>Neurologist</p>
                </div>

            </div>
        </td>

        <td>Neurology</td>
        <td>11+ years</td>
        <td>⭐ 4.8 (198)</td>

        <td>
            <span class="status active">
                ● Available
            </span>
        </td>

        <td>

            <div class="action-buttons">

                <button>
                    <i class="ri-eye-line"></i>
                </button>

                <button>
                    <i class="ri-delete-bin-line"></i>
                </button>

            </div>

        </td>

    </tr>


    <tr>

        <td>
            <div class="doctor-info">

                <div class="doctor-avatar">JA</div>

                <div>
                    <h4>Dr. James Anderson</h4>
                    <p>Psychiatrist</p>
                </div>

            </div>
        </td>

        <td>Psychiatry</td>
        <td>13+ years</td>
        <td>⭐ 4.9 (144)</td>

        <td>
            <span class="status active">
                ● Available
            </span>
        </td>

        <td>

            <div class="action-buttons">

                <button>
                    <i class="ri-eye-line"></i>
                </button>

                <button>
                    <i class="ri-delete-bin-line"></i>
                </button>

            </div>

        </td>

    </tr>

</tbody>

                </table>

            </div>

        </section>

    </main>

</div>

@endsection