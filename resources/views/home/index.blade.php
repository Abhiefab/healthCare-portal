@extends('layouts.app')

@section('title', 'Medicom - Healthcare Portal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

<section class="hero">

    <div class="container hero-container">

        <!-- LEFT CONTENT -->
        <div class="hero-content">

            <h1>
                Your trusted partner <br>
                in healthcare
            </h1>

            <p>
                Our experienced doctors and healthcare specialists are
                committed to helping you feel better, recover faster,
                and stay confident in every step of your health journey.
            </p>

            <!-- BUTTONS -->
            <div class="hero-buttons">

                <a href="#" class="primary-btn">
                    Book an Appointment
                </a>

                <a href="#" class="secondary-btn">
                    View Services
                </a>

            </div>

            <!-- DOCTOR SECTION -->
            <div class="doctor-preview">

                <div class="doctor-preview-top">

                    <h4>
                        Meet Our Medical Experts
                    </h4>

                    <div class="doctor-arrows">

                        <button>
                            ←
                        </button>

                        <button class="active-arrow">
                            →
                        </button>

                    </div>

                </div>

                <div class="doctor-cards">

                    <div class="doctor-card">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=600&auto=format&fit=crop" alt="">
                    </div>

                    <div class="doctor-card rotate-card">
                        <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop" alt="">
                    </div>

                    <div class="doctor-card">
                        <img src="https://images.unsplash.com/photo-1594824475317-29bb2c72b8d8?q=80&w=600&auto=format&fit=crop" alt="">
                    </div>

                    <div class="see-all-card">

                        <span>
                            See all →
                        </span>

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="hero-image-section">

            <div class="hero-image-bg"></div>

            <img
                src="{{ asset('images/anatomy.png') }}"
                alt="Healthcare Anatomy"
                class="hero-image"
            >

            <div class="floating-social">

                <span>◎</span>
                <span>➤</span>
                <span>✦</span>

            </div>

           

        </div>

    </div>

</section>

@endsection