<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - CMS</title>
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 4px;
            padding: 3rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .login-logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.3em;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 0.625rem;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            padding: 0.875rem 1rem;
            color: #ffffff;
            font-size: 0.875rem;
            font-family: inherit;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.05);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .form-checkbox input[type="checkbox"] {
            width: 1.125rem;
            height: 1.125rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 0.25rem;
            background: transparent;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
            position: relative;
            transition: all 0.3s ease;
        }

        .form-checkbox input[type="checkbox"]:checked {
            background: #ffffff;
            border-color: #ffffff;
        }

        .form-checkbox input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 4px;
            height: 8px;
            border: solid #000000;
            border-width: 0 2px 2px 0;
        }

        .form-checkbox label {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.6);
            user-select: none;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: #ffffff;
            color: #000000;
            border: 1px solid #ffffff;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.85);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .login-footer-link {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-footer-link:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">CMS</div>
                <div class="login-subtitle">Admin Panel</div>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="form-input"
                        placeholder="admin@yourdomain.com"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="form-input"
                        placeholder="Enter your password"
                    >
                </div>

                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label>Remember me</label>
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    Sign In
                </button>
            </form>

            <div class="login-footer">
                <a href="{{ route('home') }}" class="login-footer-link">← Back to Website</a>
            </div>
        </div>
    </div>
</body>
</html>