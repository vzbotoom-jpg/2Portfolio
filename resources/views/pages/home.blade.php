{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app')

@section('title', '')
@section('meta_description', 'Full-Stack Developer Portfolio - Creating Digital Excellence Through Innovation')

@section('content')
    {{-- Hero Section --}}
    @include('components.sections.hero-section', [
        'title' => $heroData['title'] ?? 'CREATING THE FUTURE',
        'subtitle' => $heroData['subtitle'] ?? null,
        'description' => $heroData['description'] ?? null,
        'backgroundImage' => $heroData['background']['image'] ?? null,
        'backgroundVideo' => $heroData['background']['video'] ?? null,
        'overlayOpacity' => $heroData['background']['overlay_opacity'] ?? 0.5,
        'primaryCta' => $heroData['cta_primary'] ?? null,
        'secondaryCta' => $heroData['cta_secondary'] ?? null,
        'showScrollIndicator' => true,
    ])
    
    {{-- Stats Section --}}
    @include('components.sections.stats-section', [
        'stats' => $stats ?? [],
        'background' => 'gradient',
    ])

   
    {{-- Project Showcase Section --}}
    @include('components.sections.collaboration-section', [
        'title' => 'PROJECTS I BUILT',
        'subtitle' => 'A scrolling showcase of my recent work and product launches.',
        'speed' => 'normal',
        'pauseOnHover' => true,
        'showGradient' => true,
        'background' => 'transparent',
        'brands' => $projectBrands ?? [],
    ])
    
    {{-- Projects Section --}}
    @include('components.sections.projects-section', [
        'projects' => $featuredProjects ?? [],
        'title' => 'FEATURED PROJECTS',
        'subtitle' => 'A selection of my recent and most impactful work',
        'showViewAll' => true,
    ])

     {{-- Collaboration Section --}}
    @include('components.sections.collaboration-section', [
        'title' => 'TRUSTED BY INNOVATIVE COMPANIES',
        'subtitle' => 'Proud to have collaborated with amazing brands worldwide',
        'speed' => 'slow',
        'pauseOnHover' => true,
        'showGradient' => true,
    ])

    
    {{-- Skills Section --}}
    @include('components.sections.skills-section', [
        'skills' => $skills ?? [],
        'title' => 'TECHNICAL EXPERTISE',
        'subtitle' => 'Specializing in modern web technologies and frameworks, I build scalable, high-performance digital solutions that push the boundaries of what\'s possible.',
        'layout' => 'split',
    ])
    
    {{-- Services Section --}}
    @include('components.sections.services-section', [
        'services' => $services ?? [],
        'title' => 'SERVICES',
        'subtitle' => 'Comprehensive digital solutions tailored to your specific needs',
    ])
    
    {{-- Testimonials Section --}}
    @include('components.sections.testimonials-section', [
        'testimonials' => $testimonials ?? [],
        'title' => 'WHAT CLIENTS SAY',
        'subtitle' => 'Don\'t just take my word for it - hear from some of my clients',
    ])
    
    {{-- Contact Section --}}
    @include('components.sections.contact-section', [
        'contactInfo' => $contactInfo ?? [],
        'title' => 'GET IN TOUCH',
        'subtitle' => 'Have a project in mind? Let\'s work together to create something extraordinary.',
    ])
@endsection

@push('scripts')
    {{-- Initialize AOS (Animate on Scroll) --}}
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            disable: 'mobile'
        });
    </script>
    
    {{-- Particles.js (Optional) --}}
    @if(isset($heroData['particles']) && $heroData['particles'])
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <script>
            particlesJS('particles-js', {
                particles: {
                    number: { value: 50, density: { enable: true, value_area: 800 } },
                    color: { value: '#ffffff' },
                    opacity: { value: 0.1, random: false },
                    size: { value: 2, random: true },
                    line_linked: { enable: true, distance: 150, color: '#ffffff', opacity: 0.05, width: 1 },
                    move: { enable: true, speed: 1, direction: 'none', random: false, straight: false, out_mode: 'out', bounce: false }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: { onhover: { enable: true, mode: 'grab' }, onclick: { enable: false }, resize: true },
                    modes: { grab: { distance: 140, line_linked: { opacity: 0.2 } } }
                },
                retina_detect: true
            });
        </script>
    @endif
@endpush