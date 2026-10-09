@extends('layouts.login')

@section('title', 'Admin Login')

@section('content')
<div class="login-wrapper">
    {{-- ============================================ --}}
    {{-- LEFT PANEL — Hero / Branding                 --}}
    {{-- ============================================ --}}
    <div class="login-hero">
        {{-- Background Image --}}
        <div class="login-hero-bg"></div>
        <div class="login-hero-grid"></div>
        
        {{-- Hero Content --}}
        <div class="login-hero-content">
            {{-- Logo --}}
            <div class="login-hero-logo">
                <svg class="login-hero-logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4L36 12V28L20 36L4 28V12L20 4Z" stroke="white" stroke-width="2" fill="none"/>
                    <path d="M20 4L36 12L20 20L4 12L20 4Z" fill="white" opacity="0.9"/>
                    <path d="M20 20L36 12V28L20 36V20Z" fill="white" opacity="0.6"/>
                    <path d="M20 20L4 12V28L20 36V20Z" fill="white" opacity="0.3"/>
                </svg>
                <span class="login-hero-logo-text">CMS</span>
            </div>
            
            {{-- Tagline --}}
            <h1 class="login-hero-title">
                A tool for managing<br>
                <span>a greater future.</span>
            </h1>
            
            {{-- Divider --}}
            <div class="login-hero-divider"></div>
            
            {{-- Description --}}
            <p class="login-hero-description">
                Platform for managing UMKM business, finance, 
                and growing faster with technology and AI.
            </p>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- RIGHT PANEL — Login Form                     --}}
    {{-- ============================================ --}}
    <div class="login-form-panel">
        <div class="login-card">
            {{-- Card Logo --}}
            <div class="login-card-logo">
                <svg class="login-card-logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4L36 12V28L20 36L4 28V12L20 4Z" stroke="white" stroke-width="2" fill="none"/>
                    <path d="M20 4L36 12L20 20L4 12L20 4Z" fill="white" opacity="0.9"/>
                    <path d="M20 20L36 12V28L20 36V20Z" fill="white" opacity="0.6"/>
                    <path d="M20 20L4 12V28L20 36V20Z" fill="white" opacity="0.3"/>
                </svg>
                <span class="login-card-logo-text">CMS</span>
            </div>

            {{-- Heading --}}
            <h2 class="login-card-heading">Welcome back</h2>
            <p class="login-card-subheading">Log in to your account to continue managing.</p>

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="login-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                {{-- Email Field --}}
                <div class="form-field">
                    <label for="email" class="form-field-label">Email or Username</label>
                    <div class="form-field-input-wrapper">
                        <svg class="form-field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            class="form-field-input"
                            placeholder="Enter your email or username"
                            autocomplete="email"
                        >
                    </div>
                </div>

                {{-- Password Field --}}
                <div class="form-field">
                    <label for="password" class="form-field-label">Password</label>
                    <div class="form-field-input-wrapper">
                        <svg class="form-field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="form-field-input"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            style="padding-right: 3rem;"
                        >
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                            <svg id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeOffIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Remember me</label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn-login" id="loginBtn">
                    <span id="btnText">Log In</span>
                    <svg id="btnArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    <div class="spinner" id="btnSpinner" style="display: none;"></div>
                </button>
            </form>

            {{-- Divider --}}
            <div class="login-divider">
                <div class="login-divider-line"></div>
                <span class="login-divider-text">or</span>
                <div class="login-divider-line"></div>
            </div>

            {{-- Google Button (Optional) --}}
            <button type="button" class="btn-google" onclick="alert('Google login coming soon!')">
                <svg viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Continue with Google
            </button>

            {{-- Footer --}}
            <div class="login-footer">
                Don't have an account? <a href="{{ route('home') }}">Contact support</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Password Toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            eyeIcon.style.display = 'none';
            eyeOffIcon.style.display = 'block';
        } else {
            eyeIcon.style.display = 'block';
            eyeOffIcon.style.display = 'none';
        }
    });

    // Form Submission with Loading State
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = document.getElementById('btnText');
    const btnArrow = document.getElementById('btnArrow');
    const btnSpinner = document.getElementById('btnSpinner');

    loginForm.addEventListener('submit', function(e) {
        // Show loading state
        loginBtn.disabled = true;
        btnText.textContent = 'Signing in...';
        btnArrow.style.display = 'none';
        btnSpinner.style.display = 'block';
    });

    // Auto-focus email field
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        if (emailInput && !emailInput.value) {
            emailInput.focus();
        }
    });

    // Keyboard shortcut: Enter to submit
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && document.activeElement.tagName !== 'BUTTON') {
            loginForm.submit();
        }
    });
</script>
@endpush