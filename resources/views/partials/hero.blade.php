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
        <img src="{{ asset('images/doctors/doctor1.jpg') }}" alt="Doctor">
    </div>

    <div class="doctor-card rotate-card">
        <img src="{{ asset('images/doctors/doctor3.png') }}" alt="Doctor">
    </div>

    <div class="doctor-card">
        <img src="{{ asset('images/doctors/doctor3.jpg') }}" alt="Doctor">
    </div>

  <div class="see-all-card">
    <a href="{{ route('doctors') }}">
        See all →
    </a>
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

            

        </div>

    </div>

</section>