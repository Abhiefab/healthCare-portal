<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In — Medicom</title>

    <!-- INTER FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body class="auth-body">

    <div class="auth-wrapper">

        <!-- ===== LEFT PANEL ===== -->
        <div class="auth-left">

            <!-- Logo -->
            <a href="/" class="auth-logo">
                <div class="logo-icon"></div>
                <span>Medicom</span>
            </a>

            <!-- Headline -->
            <div class="auth-left-content">

                <h2>Your health journey<br>starts here.</h2>

                <p>Access your appointments, records, and expert doctors — all in one place.</p>

                <!-- Trust badges -->
                <div class="auth-badges">

                    <div class="auth-badge">
                        <span class="badge-num">500+</span>
                        <span class="badge-lbl">Expert Doctors</span>
                    </div>

                    <div class="auth-badge-divider"></div>

                    <div class="auth-badge">
                        <span class="badge-num">50k+</span>
                        <span class="badge-lbl">Happy Patients</span>
                    </div>

                    <div class="auth-badge-divider"></div>

                    <div class="auth-badge">
                        <span class="badge-num">99%</span>
                        <span class="badge-lbl">Satisfaction</span>
                    </div>

                </div>

            </div>

            <!-- Decorative circles -->
            <div class="auth-deco auth-deco-1"></div>
            <div class="auth-deco auth-deco-2"></div>

        </div>

        <!-- ===== RIGHT PANEL ===== -->
        <div class="auth-right">

            <div class="auth-form-wrap">

                <!-- Header -->
                <div class="auth-form-header">
                    <h1>Welcome back</h1>
                    <p>Log in to your Medicom account</p>
                </div>

                <!-- Form -->
                @if ($errors->any())
                    <div class="auth-alert" role="alert">
                        <strong>Please check the login details.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="auth-form" action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <div class="input-wrap">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                            >
                        </div>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-group-row">
                            <label for="password">Password</label>
                            <a href="#" class="forgot-link">Forgot password?</a>
                        </div>
                        <div class="input-wrap">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePass('password', this)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="form-check">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me for 30 days</label>
                    </div>

                    <button type="submit" class="auth-submit-btn">
                        Log In
                    </button>

                </form>

                <!-- Switch to signup -->
                <p class="auth-switch">
                    Don't have an account?
                    <a href="/signup">Create one free</a>
                </p>

            </div>

        </div>

    </div>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            btn.style.opacity = isText ? '0.5' : '1';
        }
    </script>

</body>
</html>
