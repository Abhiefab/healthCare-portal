@extends('layouts.app')

@push('styles')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
/>

<link
    rel="stylesheet"
    href="{{ asset('css/doctors.css') }}"
>

@endpush

@section('title', 'Doctors - Medicom')

@section('content')

<section class="doctors-page">

    <div class="container">

        <!-- =========================
             HERO SECTION
        ========================== -->

        <div class="doctors-hero">

            <div class="hero-content">

                <div class="breadcrumb">

                    <a href="{{ route('home') }}">
                        Home
                    </a>

                    <i class="ri-arrow-right-s-line"></i>

                    <span>
                        Doctors
                    </span>

                </div>

                <h1>
                    All Doctors
                </h1>

                <p>
                    Browse our experienced and qualified doctors across
                    multiple specialties and healthcare departments.
                </p>

            </div>

            <div class="hero-image"></div>

        </div>

        <!-- =========================
             FILTER SECTION
        ========================== -->

        <div class="filter-wrapper">

            <div class="search-box">

                <i class="ri-search-line"></i>

                <input
                    type="text"
                    placeholder="Search doctor by name, specialty or keyword..."
                >

            </div>

            <div class="filter-select">

                <select>

                    <option>All Specialties</option>
                    <option>Cardiology</option>
                    <option>Neurology</option>
                    <option>Dermatology</option>
                    <option>Pediatrics</option>
                    <option>Orthopedics</option>
                    <option>Psychiatry</option>

                </select>

            </div>

            <div class="filter-select">

                <select>

                    <option>All Locations</option>
                    <option>New York</option>
                    <option>California</option>
                    <option>Chicago</option>
                    <option>Boston</option>

                </select>

            </div>

            <div class="filter-select">

                <select>

                    <option>Availability</option>
                    <option>Available Today</option>
                    <option>Available Tomorrow</option>
                    <option>Online Consultation</option>

                </select>

            </div>

            <div class="filter-select">

                <select>

                    <option>Sort by: Popular</option>
                    <option>Highest Rated</option>
                    <option>Most Experienced</option>

                </select>

            </div>

            <button class="filter-btn">

                <i class="ri-equalizer-line"></i>

                Filter

            </button>

        </div>

        <!-- =========================
             DOCTORS GRID
        ========================== -->

        <div class="doctors-grid">

            <!-- CARD 1 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor5.png') }}"
                        alt="Dr. Michael Carter"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. Michael Carter
                    </h3>

                    <h5>
                        Orthopedic Surgeon
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.9 (230 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            Main Clinic, New York
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            12+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CARD 2 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor7.png') }}"
                        alt="Dr. Sarah Johnson"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. Sarah Johnson
                    </h3>

                    <h5>
                        Pediatric Specialist
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.8 (185 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            Kids Care Clinic, Boston
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            8+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CARD 3 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor6.png') }}"
                        alt="Dr. David Wilson"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. David Wilson
                    </h3>

                    <h5>
                        Cardiologist
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.9 (210 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            Heart Care Center, Chicago
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            15+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CARD 4 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor9.png') }}"
                        alt="Dr. Emily Brown"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. Emily Brown
                    </h3>

                    <h5>
                        Dermatologist
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.7 (160 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            Skin Health Clinic, California
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            9+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CARD 5 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor3.png') }}"
                        alt="Dr. Olivia Martinez"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. Olivia Martinez
                    </h3>

                    <h5>
                        Neurologist
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.8 (198 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            Neuro Care Institute, Boston
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            11+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CARD 6 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor2.jpg') }}"
                        alt="Dr. James Anderson"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. James Anderson
                    </h3>

                    <h5>
                        Psychiatrist
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.9 (144 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            Mind Wellness Center, Seattle
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            13+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CARD 7 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor13.png') }}"
                        alt="Dr. Sophia Lee"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. Sophia Lee
                    </h3>

                    <h5>
                        Gynecologist
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.8 (176 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            Women's Health Center, Miami
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            10+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CARD 8 -->

            <div class="doctor-card">

                <div class="doctor-image">

                    <img
                        src="{{ asset('images/doctors/doctor10.png') }}"
                        alt="Dr. Ethan Walker"
                    >

                </div>

                <div class="doctor-info">

                    <div class="doctor-status">

                        <span></span>

                        Available

                    </div>

                    <h3>
                        Dr. Ethan Walker
                    </h3>

                    <h5>
                        General Physician
                    </h5>

                    <div class="doctor-meta">

                        <p>
                            <i class="ri-star-fill"></i>
                            4.7 (132 reviews)
                        </p>

                        <p>
                            <i class="ri-map-pin-line"></i>
                            City Medical Hospital, Texas
                        </p>

                        <p>
                            <i class="ri-briefcase-line"></i>
                            7+ years experience
                        </p>

                    </div>

                    <div class="doctor-actions">

                        <a href="#" class="profile-btn">
                            View Profile
                        </a>

                        <button class="appointment-btn">
                            <i class="ri-calendar-line"></i>
                        </button>

                    </div>

                </div>

            </div>

        </div>

        <!-- =========================
             PAGINATION
        ========================== -->

        <div class="pagination">

            <button class="page-btn active">
                1
            </button>

            <button class="page-btn">
                2
            </button>

            <button class="page-btn">
                3
            </button>

            <button class="page-btn">
                <i class="ri-arrow-right-s-line"></i>
            </button>

        </div>

    </div>

</section>
<script>

document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.querySelector(".search-box input");

    const specialtySelect =
        document.querySelectorAll(".filter-select select")[0];

    const locationSelect =
        document.querySelectorAll(".filter-select select")[1];

    const availabilitySelect =
        document.querySelectorAll(".filter-select select")[2];

    const doctorCards =
        document.querySelectorAll(".doctor-card");

    function filterDoctors() {

        const searchText =
            searchInput.value.toLowerCase();

        const specialty =
            specialtySelect.value.toLowerCase();

        const location =
            locationSelect.value.toLowerCase();

        const availability =
            availabilitySelect.value.toLowerCase();

        doctorCards.forEach(card => {

            const name =
                card.querySelector("h3")
                .innerText
                .toLowerCase();

            const specialtyText =
                card.querySelector("h5")
                .innerText
                .toLowerCase();

            const locationText =
                card.querySelector(".doctor-meta")
                .innerText
                .toLowerCase();

            const statusText =
                card.querySelector(".doctor-status")
                .innerText
                .toLowerCase();

            let matchesSearch =
                name.includes(searchText) ||
                specialtyText.includes(searchText) ||
                locationText.includes(searchText);

            let matchesSpecialty = true;

            if (specialty !== "all specialties") {

                if (specialty === "orthopedics") {
                    matchesSpecialty =
                        specialtyText.includes("orthopedic");
                }

                else if (specialty === "pediatrics") {
                    matchesSpecialty =
                        specialtyText.includes("pediatric");
                }

                else if (specialty === "cardiology") {
                    matchesSpecialty =
                        specialtyText.includes("cardio");
                }

                else if (specialty === "neurology") {
                    matchesSpecialty =
                        specialtyText.includes("neuro");
                }

                else if (specialty === "dermatology") {
                    matchesSpecialty =
                        specialtyText.includes("derma");
                }

                else if (specialty === "psychiatry") {
                    matchesSpecialty =
                        specialtyText.includes("psychi");
                }
            }

            let matchesLocation =
                location === "all locations" ||
                locationText.includes(location);

            let matchesAvailability =
                availability === "availability" ||
                statusText.includes("available");

            if (
                matchesSearch &&
                matchesSpecialty &&
                matchesLocation &&
                matchesAvailability
            ) {
                card.style.display = "block";
            }

            else {
                card.style.display = "none";
            }

        });

    }

    searchInput.addEventListener(
        "input",
        filterDoctors
    );

    specialtySelect.addEventListener(
        "change",
        filterDoctors
    );

    locationSelect.addEventListener(
        "change",
        filterDoctors
    );

    availabilitySelect.addEventListener(
        "change",
        filterDoctors
    );

});

</script>

@endsection