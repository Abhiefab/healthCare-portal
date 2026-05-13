<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — Medicom</title>

    <!-- INTER FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">

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

                <h2>Join thousands of<br>healthier people.</h2>

                <p>Book appointments, consult doctors online, and manage your health records — for free.</p>

                <!-- Feature list -->
                <ul class="auth-feature-list">

                    <li>
                        <span class="auth-feature-check">✓</span>
                        Instant appointment booking
                    </li>

                    <li>
                        <span class="auth-feature-check">✓</span>
                        Secure digital health records
                    </li>

                    <li>
                        <span class="auth-feature-check">✓</span>
                        24/7 doctor consultations
                    </li>

                    <li>
                        <span class="auth-feature-check">✓</span>
                        Free to join, no hidden fees
                    </li>

                </ul>

            </div>

            <!-- Decorative circles -->
            <div class="auth-deco auth-deco-1"></div>
            <div class="auth-deco auth-deco-2"></div>

        </div>

        <!-- ===== RIGHT PANEL ===== -->
        <div class="auth-right">

            <div class="auth-form-wrap auth-form-wrap--signup">

                <!-- Header -->
                <div class="auth-form-header">
                    <h1>Create your account</h1>
                    <p>It's free and only takes a minute</p>
                </div>

                <!-- Form -->
                <form class="auth-form" action="/signup" method="POST">
                    @csrf

                    <!-- Role selector -->
                    <div class="role-selector">

                        <input type="radio" id="role-patient" name="role" value="patient" checked>
                        <label for="role-patient" class="role-option">
                            <span class="role-icon">🧑‍⚕️</span>
                            <span>I'm a Patient</span>
                        </label>

                        <input type="radio" id="role-doctor" name="role" value="doctor">
                        <label for="role-doctor" class="role-option">
                            <span class="role-icon">👨‍⚕️</span>
                            <span>I'm a Doctor</span>
                        </label>

                    </div>

                    <!-- Name row -->
                    <div class="form-row">

                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <div class="input-wrap">
                                <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <input type="text" id="first_name" name="first_name" placeholder="John" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <div class="input-wrap">
                                <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <input type="text" id="last_name" name="last_name" placeholder="Doe" required>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <div class="input-wrap">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <input type="email" id="email" name="email" placeholder="you@example.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input type="password" id="password" name="password" placeholder="Min. 8 characters" required>
                            <button type="button" class="toggle-password" onclick="togglePass('password', this)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <div class="password-strength" id="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                        <span class="strength-label" id="strength-label"></span>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirm password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input type="password" id="password_confirm" name="password_confirmation" placeholder="Repeat your password" required>
                            <button type="button" class="toggle-password" onclick="togglePass('password_confirm', this)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="form-check">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agree to the
                            <a href="#">Terms of Service</a>
                            and
                            <a href="#">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="auth-submit-btn">
                        Create Account
                    </button>

                </form>

                <!-- Switch to login -->
                <p class="auth-switch">
                    Already have an account?
                    <a href="/login">Log in</a>
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

        /* Password strength meter */
        const pwInput = document.getElementById('password');
        const fill = document.getElementById('strength-fill');
        const label = document.getElementById('strength-label');

        const levels = [
            { max: 1, color: '#ef4444', text: 'Too weak' },
            { max: 2, color: '#f59e0b', text: 'Weak' },
            { max: 3, color: '#f59e0b', text: 'Fair' },
            { max: 4, color: '#10b981', text: 'Strong' },
            { max: 5, color: '#10b981', text: 'Very strong' },
        ];

        pwInput.addEventListener('input', () => {
            const val = pwInput.value;
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            if (val.length >= 12) score++;

            const lvl = levels[score - 1] || { color: '#e5e7eb', text: '' };
            fill.style.width = (score / 5 * 100) + '%';
            fill.style.background = lvl.color;
            label.textContent = lvl.text;
            label.style.color = lvl.color;
        });
    </script>

</body>
</html>
