@extends('layouts.login')

@section('title', 'Forgot Password')

@section('content')
<div class="login-wrapper">
    <div class="login-hero">
        <div class="login-hero-bg"></div>
        <div class="login-hero-grid"></div>
        
        <div class="login-hero-content">
            <div class="login-hero-logo">
                <svg class="login-hero-logo-icon" viewBox="0 0 40 40" fill="none">
                    <path d="M20 4L36 12V28L20 36L4 28V12L20 4Z" stroke="white" stroke-width="2" fill="none"/>
                    <path d="M20 4L36 12L20 20L4 12L20 4Z" fill="white" opacity="0.9"/>
                </svg>
                <span class="login-hero-logo-text">CMS</span>
            </div>
            
            <h1 class="login-hero-title">
                Reset your<br>
                <span>password easily.</span>
            </h1>
            
            <div class="login-hero-divider"></div>
            
            <p class="login-hero-description">
                Enter your email address and we'll send you a link to reset your password.
            </p>
        </div>
    </div>

    <div class="login-form-panel">
        <div class="login-card">
            <div class="login-card-logo">
                <svg class="login-card-logo-icon" viewBox="0 0 40 40" fill="none">
                    <path d="M20 4L36 12V28L20 36L4 28V12L20 4Z" stroke="white" stroke-width="2" fill="none"/>
                    <path d="M20 4L36 12L20 20L4 12L20 4Z" fill="white" opacity="0.9"/>
                </svg>
                <span class="login-card-logo-text">CMS</span>
            </div>

            <h2 class="login-card-heading">Forgot Password</h2>
            <p class="login-card-subheading">Enter your email to receive a reset link.</p>

            @if(session('status'))
                <div class="login-error" style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2); color: #10b981;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-field">
                    <label for="email" class="form-field-label">Email Address</label>
                    <div class="form-field-input-wrapper">
                        <svg class="form-field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            autofocus
                            class="form-field-input"
                            placeholder="Enter your email"
                        >
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <span>Send Reset Link</span>
                </button>
            </form>

            <div class="login-footer">
                Remember your password? <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
</div>
@endsection