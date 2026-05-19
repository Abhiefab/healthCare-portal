<footer class="footer">

    <div class="container footer-container">

        <!-- LEFT -->
        <div class="footer-brand">

            <a href="/" class="footer-logo">

                <span class="footer-logo-dot"></span>

                Medicom

            </a>

            <p>
                Advanced healthcare portal providing appointments,
                specialist consultations, patient management,
                diagnostics, and emergency medical support.
            </p>

            <div class="footer-socials">

                <a href="#">
                    Instagram
                </a>

                <a href="#">
                    Twitter
                </a>

                <a href="#">
                    LinkedIn
                </a>

            </div>

        </div>

        <!-- RIGHT LINKS -->
        <div class="footer-links-wrapper">

            <!-- QUICK LINKS -->
            <div class="footer-links">

                <h4>
                    Quick Links
                </h4>

                <a href="/">
                    Home
                </a>

                <a href="/doctors">
                    Doctors
                </a>

                <a href="/appointments">
                    Appointments
                </a>

                @auth

                    @php
                        $footerDashboardRoute = match (auth()->user()->role) {
                            'admin' => 'admin.dashboard',
                            'doctor' => 'doctor.dashboard',
                            'patient' => 'patient.dashboard',
                            default => 'login',
                        };
                    @endphp

                    <a href="{{ route($footerDashboardRoute) }}">
                        Dashboard
                    </a>

                @else

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                @endauth

            </div>

            <!-- SERVICES -->
            <div class="footer-links">

                <h4>
                    Medical Services
                </h4>

                <a href="#services">
                    Cardiology
                </a>

                <a href="/#services">
                    Neurology
                </a>

                <a href="/#services">
                    Orthopedics
                </a>

                <a href="/#services">
                    Dental Care
                </a>

            </div>

            <!-- SUPPORT -->
            <div class="footer-links">

                <h4>
                    Patient Support
                </h4>

                <a href="#faq">
                    FAQs
                </a>

                <a href="/contact">
                    Contact Support
                </a>

                <a href="/insurance">
                    Health Insurance
                </a>

                <a href="/emergency">
                    Emergency Care
                </a>

            </div>

        </div>

    </div>

    <!-- BOTTOM -->
    <div class="footer-bottom">

        <div class="container footer-bottom-container">

            <p>
                © 2026 Medicom. All rights reserved.
            </p>

            <div class="footer-bottom-links">

                <span>
                    +91 70502 40563
                </span>

                <span>
                    support@medicom.com
                </span>

                <span>
                    Punjab, India
                </span>

            </div>

        </div>

    </div>

</footer>