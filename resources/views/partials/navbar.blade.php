<nav class="navbar">

    <div class="container navbar-container">

        <!-- LOGO -->
        <a href="/" class="logo">

            <div class="logo-icon"></div>

            <span>Medicom</span>

        </a>

        <!-- NAV LINKS -->
        <ul class="nav-links">

            <li>
                <a href="/" class="active">Home</a>
            </li>

            <li>
                <a href="#services">Services</a>
            </li>

            <li>
                <a href="#doctors">Doctors</a>
            </li>

            <li>
                <a href="#features">Features</a>
            </li>

            <li>
                <a href="#faq">FAQ</a>
            </li>

        </ul>

        <!-- RIGHT SIDE -->
        <div class="nav-right">


            <!-- AUTH -->
            <div class="auth-box">
                @auth
                    @php
                        $dashboardRoute = match (auth()->user()->role) {
                            'admin' => 'admin.dashboard',
                            'doctor' => 'doctor.dashboard',
                            default => 'patient.dashboard',
                        };
                    @endphp

                    <span class="session-pill">
                        {{ auth()->user()->name }} · {{ ucfirst(auth()->user()->role) }}
                    </span>

                    <div class="divider"></div>

                    <a href="{{ route($dashboardRoute) }}" class="login-btn">
                        Dashboard
                    </a>

                    <div class="divider"></div>

                    <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="login-btn">
                        Log in
                    </a>

                    <div class="divider"></div>

                    <a href="{{ route('signup') }}" class="signup-btn">
                        Sign up
                    </a>
                @endauth

            </div>

        </div>

        <!-- MOBILE MENU -->
        <button class="mobile-menu-btn">

            <span></span>
            <span></span>
            <span></span>

        </button>

    </div>

</nav>
