{{-- resources/views/layouts/partials/head.blade.php --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    // Home page (no @section('title', ...) set by the view) shows
    // just the brand name. Any other page that explicitly sets a
    // title keeps the "Page Title | Brand" format.
    $pageTitle = trim(View::yieldContent('title', ''));
    $siteName = config('app.name', 'PORTFOLIO');
    $fullTitle = $pageTitle !== '' ? "{$pageTitle} | {$siteName}" : $siteName;
@endphp

{{-- Primary Meta Tags --}}
<title>{{ $fullTitle }}</title>
<meta name="description" content="@yield('meta_description', 'Full-Stack Developer Portfolio - Creating Digital Excellence Through Innovation')">
<meta name="keywords" content="@yield('meta_keywords', 'web developer, full-stack developer, laravel, portfolio, vue.js, react')">
<meta name="author" content="{{ config('portfolio.author', 'Your Name') }}">
<meta name="robots" content="index, follow">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ url()->current() }}">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="@yield('meta_description', 'Full-Stack Developer Portfolio - Creating Digital Excellence')">
<meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="{{ config('app.name', 'PORTFOLIO') }}">
<meta property="og:locale" content="en_US">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@yourusername">
<meta name="twitter:creator" content="@yourusername">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="@yield('meta_description', 'Full-Stack Developer Portfolio')">
<meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">

{{-- Additional SEO Meta Tags --}}
<meta name="theme-color" content="#000000">
<meta name="msapplication-TileColor" content="#000000">
<meta name="format-detection" content="telephone=no">

{{-- Favicon and Icons (only output links if files exist) --}}
@php
    $faviconIco = public_path('images/icons/favicon/favicon.ico');
    $favicon32 = public_path('images/icons/favicon/favicon-32x32.png');
    $favicon16 = public_path('images/icons/favicon/favicon-16x16.png');
    $appleIcon = public_path('images/icons/favicon/apple-touch-icon.png');
@endphp

@if(file_exists($faviconIco))
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icons/favicon/favicon.ico') }}">
@endif
@if(file_exists($favicon32))
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icons/favicon/favicon-32x32.png') }}">
@endif
@if(file_exists($favicon16))
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icons/favicon/favicon-16x16.png') }}">
@endif
@if(file_exists($appleIcon))
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icons/favicon/apple-touch-icon.png') }}">
@endif
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

{{-- Preconnect to External Resources --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net">

{{-- Google Fonts - Inter --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

{{-- Custom Fonts (Optional) - only include if the files exist to prevent 404s --}}
@php
    $hasDdin = file_exists(public_path('fonts/D-DIN.woff2')) || file_exists(public_path('fonts/D-DIN-Bold.woff2'));
    $hasInterVar = file_exists(public_path('fonts/Inter-Variable.woff2'));
@endphp

@if($hasDdin || $hasInterVar)
    <style>
        @if($hasDdin)
            @font-face {
                font-family: 'D-DIN';
                src: url('{{ asset("fonts/D-DIN.woff2") }}') format('woff2');
                font-weight: 400;
                font-style: normal;
                font-display: swap;
            }

            @font-face {
                font-family: 'D-DIN';
                src: url('{{ asset("fonts/D-DIN-Bold.woff2") }}') format('woff2');
                font-weight: 700;
                font-style: normal;
                font-display: swap;
            }
        @endif

        @if($hasInterVar)
            @font-face {
                font-family: 'Inter';
                src: url('{{ asset("fonts/Inter-Variable.woff2") }}') format('woff2');
                font-weight: 100 900;
                font-style: normal;
                font-display: swap;
            }
        @endif
    </style>
@endif

{{-- Vite Assets --}}
@vite(['resources/css/app.css', 'resources/css/animations.css', 'resources/css/typography.css'])

{{-- Inline Critical CSS --}}
<style>
    /* Critical above-the-fold styles */
    body {
        background-color: #000000;
        color: #ffffff;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    /* Loading screen styles — short, snappy fade so the loader
       doesn't outlast the actual page-ready time on fast connections */
    #page-loader {
        transition: opacity 0.25s ease-out, visibility 0.25s ease-out;
    }
    
    #page-loader.hidden {
        opacity: 0;
        visibility: hidden;
    }
    
    /* Smooth scrollbar */
    @media (min-width: 768px) {
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #000000;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #333333;
            border-radius: 4px;
            transition: background 0.3s ease;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555555;
        }
    }
    
    /* Selection styling */
    ::selection {
        background-color: rgba(255, 255, 255, 0.9);
        color: #000000;
    }
    
    ::-moz-selection {
        background-color: rgba(255, 255, 255, 0.9);
        color: #000000;
    }
    
    /* Focus styles */
    :focus-visible {
        outline: 2px solid rgba(255, 255, 255, 0.5);
        outline-offset: 2px;
    }
    
    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
</style>

{{-- Preload Hero Image --}}
@if(isset($heroData['background']['image']))
    <link rel="preload" as="image" href="{{ asset($heroData['background']['image']) }}" fetchpriority="high">
@endif

{{-- Additional Head Content --}}
@stack('head')