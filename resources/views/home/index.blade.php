@extends('layouts.app')

@section('title', 'Medicom - Healthcare Portal')

@push('styles')

<link rel="stylesheet" href="{{ asset('css/hero.css') }}">
<link rel="stylesheet" href="{{ asset('css/services.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">

@endpush

@section('content')

@include('partials.hero')


{{-- ===================== SERVICES ===================== --}}
<section id="services" class="services-section">
    <div class="container">

        <div class="section-header">
            <span class="section-tag">What We Offer</span>
            <h2>Our Medical Services</h2>
            <p>From routine checkups to specialized treatments, we've got every aspect of your health covered.</p>
        </div>

        <div class="services-grid">

            <div class="service-card">
                <div class="service-icon" style="background:#dbeafe;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563ff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <h3>Cardiology</h3>
                <p>Expert heart care with advanced diagnostics, ECG, echocardiography, and cardiac surgery support.</p>
                <a href="#" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background:#dcfce7;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                </div>
                <h3>General Checkups</h3>
                <p>Comprehensive health assessments and preventive screenings for all age groups.</p>
                <a href="#" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background:#fef9c3;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3>Neurology</h3>
                <p>Diagnosis and treatment of neurological conditions including stroke, epilepsy and migraines.</p>
                <a href="#" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background:#fce7f3;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#db2777" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Orthopedics</h3>
                <p>Bone, joint, and muscle care with minimally invasive surgery and physiotherapy programmes.</p>
                <a href="#" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background:#ede9fe;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <h3>Pediatrics</h3>
                <p>Dedicated child healthcare from newborns to teenagers, including vaccinations and growth tracking.</p>
                <a href="#" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background:#ffedd5;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 9.5V5a2 2 0 012-2h11a2 2 0 012 2v4.5M2 13h20M6 13v8m12-8v8"/></svg>
                </div>
                <h3>Dental Care</h3>
                <p>Full-spectrum dental services from cleanings and fillings to orthodontics and implants.</p>
                <a href="#" class="service-link">Learn more →</a>
            </div>

        </div>

    </div>
</section>

{{-- ===================== DOCTORS ===================== --}}
<section id="doctors" class="doctors-section">
    <div class="container">

        <div class="section-header">
            <span class="section-tag">Our Specialists</span>
            <h2>Meet Our Expert Doctors</h2>
            <p>A team of highly qualified and compassionate medical professionals dedicated to your well-being.</p>
        </div>

        <div class="doctors-grid">

            <div class="doctor-profile-card">
                <div class="doctor-photo">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=600&auto=format&fit=crop" alt="Dr. Sarah Mitchell">
                </div>
                <div class="doctor-info">
                    <h3>Dr. Sarah Mitchell</h3>
                    <span class="doctor-specialty">Cardiologist</span>
                    <div class="doctor-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.9 (120 reviews)</span>
                    </div>
                    <a href="#" class="doctor-book-btn">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-profile-card">
                <div class="doctor-photo">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop" alt="Dr. James O'Brien">
                </div>
                <div class="doctor-info">
                    <h3>Dr. James O'Brien</h3>
                    <span class="doctor-specialty">Neurologist</span>
                    <div class="doctor-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.8 (98 reviews)</span>
                    </div>
                    <a href="#" class="doctor-book-btn">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-profile-card">
                <div class="doctor-photo">
                    <img src="{{ asset('images/doctors/doctor9.png') }}" alt="Dr. Priya Sharma">
                </div>
                <div class="doctor-info">
                    <h3>Dr. Priya Sharma</h3>
                    <span class="doctor-specialty">Pediatrician</span>
                    <div class="doctor-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.9 (210 reviews)</span>
                    </div>
                    <a href="#" class="doctor-book-btn">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-profile-card">
                <div class="doctor-photo">
                    <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=600&auto=format&fit=crop" alt="Dr. Michael Chen">
                </div>
                <div class="doctor-info">
                    <h3>Dr. Michael Chen</h3>
                    <span class="doctor-specialty">Orthopedic Surgeon</span>
                    <div class="doctor-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="rating-count">4.7 (85 reviews)</span>
                    </div>
                    <a href="#" class="doctor-book-btn">Book Appointment</a>
                </div>
            </div>

        </div>

        <div class="section-cta">
         
            <a href="{{ route('doctors') }}" class="primary-btn">View All Doctors</a>
        </div>

    </div>
</section>

{{-- ===================== FEATURES ===================== --}}
<section id="features" class="features-section">
    <div class="container">

        <div class="features-inner">

            <div class="features-left">
                <span class="section-tag">Why Choose Us</span>
                <h2>Healthcare made simple, smart & accessible</h2>
                <p>We combine modern technology with compassionate care to give you the most seamless healthcare experience possible.</p>

                <div class="features-list">

                    <div class="feature-item">
                        <div class="feature-check">✓</div>
                        <div>
                            <h4>Online Appointment Booking</h4>
                            <p>Schedule visits with your preferred doctor in under 60 seconds, any time of day.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-check">✓</div>
                        <div>
                            <h4>24/7 Emergency Support</h4>
                            <p>Round-the-clock access to medical advice and emergency care when you need it most.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-check">✓</div>
                        <div>
                            <h4>Digital Health Records</h4>
                            <p>All your medical history, prescriptions and reports stored securely in one place.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-check">✓</div>
                        <div>
                            <h4>Video Consultations</h4>
                            <p>Consult with specialists from the comfort of your home via secure video calls.</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="features-right">
                <div class="features-stat-card">
                    <div class="features-stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Expert Doctors</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-number">50k+</span>
                            <span class="stat-label">Happy Patients</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-number">30+</span>
                            <span class="stat-label">Specialties</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-number">99%</span>
                            <span class="stat-label">Satisfaction Rate</span>
                        </div>
                    </div>
                    
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ===================== FAQ ===================== --}}
<section id="faq" class="faq-section">
    <div class="container">

        <div class="section-header">
            <span class="section-tag">Got Questions?</span>
            <h2>Frequently Asked Questions</h2>
            <p>Everything you need to know about Medicom and our services.</p>
        </div>

        <div class="faq-list">

            <div class="faq-item">
                <input type="checkbox" id="faq1" class="faq-toggle">
                <label for="faq1" class="faq-question">
                    How do I book an appointment online?
                    <span class="faq-icon">+</span>
                </label>
                <div class="faq-answer">
                    <p>Simply click on "Book an Appointment", choose your preferred doctor and specialty, select a date and time that works for you, and confirm your booking. You'll receive an instant confirmation via email.</p>
                </div>
            </div>

            <div class="faq-item">
                <input type="checkbox" id="faq2" class="faq-toggle">
                <label for="faq2" class="faq-question">
                    Are video consultations available for all specialties?
                    <span class="faq-icon">+</span>
                </label>
                <div class="faq-answer">
                    <p>Yes, video consultations are available for most specialties including general medicine, cardiology, neurology, psychiatry, and dermatology. Some physical examinations may require an in-person visit.</p>
                </div>
            </div>

            <div class="faq-item">
                <input type="checkbox" id="faq3" class="faq-toggle">
                <label for="faq3" class="faq-question">
                    How are my medical records stored and protected?
                    <span class="faq-icon">+</span>
                </label>
                <div class="faq-answer">
                    <p>All your health data is encrypted using AES-256 encryption and stored on secure, HIPAA-compliant servers. Only authorised medical personnel and yourself can access your records.</p>
                </div>
            </div>

            <div class="faq-item">
                <input type="checkbox" id="faq4" class="faq-toggle">
                <label for="faq4" class="faq-question">
                    Can I cancel or reschedule my appointment?
                    <span class="faq-icon">+</span>
                </label>
                <div class="faq-answer">
                    <p>Yes, you can cancel or reschedule any appointment up to 2 hours before the scheduled time, free of charge. Simply log in to your dashboard and manage your bookings from there.</p>
                </div>
            </div>

            <div class="faq-item">
                <input type="checkbox" id="faq5" class="faq-toggle">
                <label for="faq5" class="faq-question">
                    Do you accept health insurance?
                    <span class="faq-icon">+</span>
                </label>
                <div class="faq-answer">
                    <p>We work with most major insurance providers. You can enter your insurance details during registration and our system will automatically verify coverage for each service you book.</p>
                </div>
            </div>

            <div class="faq-item">
                <input type="checkbox" id="faq6" class="faq-toggle">
                <label for="faq6" class="faq-question">
                    Is there a 24/7 emergency helpline?
                    <span class="faq-icon">+</span>
                </label>
                <div class="faq-answer">
                    <p>Yes, our emergency support line is available 24 hours a day, 7 days a week. You can also use our in-app emergency button to connect with an on-call doctor immediately.</p>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection