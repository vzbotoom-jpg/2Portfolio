<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Dashboard') - Admin Panel</title>
    
    @vite(['resources/css/app.css', 'resources/css/admin.css'])
    
    @stack('styles')
</head>
<body class="bg-black text-white">
    <div class="admin-layout">
        {{-- Admin Sidebar --}}
        @include('components.sidebar.admin')
        
        {{-- Main Content Area --}}
        <div class="admin-main">
            {{-- Top Navigation --}}
            <div class="admin-topbar">
                {{-- Breadcrumb / Page Title --}}
                <h1 class="admin-page-title">
                    @yield('page_title', 'Dashboard')
                </h1>
                
                {{-- User Menu --}}
                <div class="admin-user-info">
                    <a href="{{ route('home') }}" target="_blank" class="admin-btn admin-btn-sm">
                        View Site
                    </a>
                    <div class="admin-user-name">
                        {{ auth()->user()->name }}
                    </div>
                </div>
            </div>
            
            {{-- Page Content --}}
            <div class="admin-content">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="admin-alert admin-alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="admin-alert admin-alert-error">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="admin-alert admin-alert-error">
                        <div style="font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem; letter-spacing: 0.1em; text-transform: uppercase;">
                            Please fix the following errors:
                        </div>
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- Main Content --}}
                @yield('content')
            </div>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>