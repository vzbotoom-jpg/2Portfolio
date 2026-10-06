{{-- resources/views/components/sections/collaboration-section.blade.php --}}
@props([
    'title' => 'TRUSTED BY',
    'subtitle' => null,
    'brands' => [],
    'speed' => 'slow', // slow, normal, fast
    'pauseOnHover' => true,
    'showGradient' => true,
    'background' => 'black',
])

@php
    $defaultBrands = [
        ['name' => 'TechCorp', 'url' => 'https://techcorp.com'],
        ['name' => 'DataFlow', 'url' => 'https://dataflow.io'],
        ['name' => 'StartupX', 'url' => 'https://startupx.com'],
        ['name' => 'DigitalPro', 'url' => 'https://digitalpro.com'],
        ['name' => 'InnovateLabs', 'url' => 'https://innovatelabs.com'],
        ['name' => 'FinTech Solutions', 'url' => 'https://fintechsolutions.com'],
        ['name' => 'MediCare Group', 'url' => 'https://medicaregroup.com'],
        ['name' => 'EduTech Inc.', 'url' => 'https://edutech.com'],
        ['name' => 'PropertyFinder', 'url' => 'https://propertyfinder.com'],
        ['name' => 'CloudBase', 'url' => 'https://cloudbase.io'],
        ['name' => 'NextGen Software', 'url' => 'https://nextgensoftware.com'],
        ['name' => 'Alpha Systems', 'url' => 'https://alphasystems.com'],
    ];
    
    $brands = !empty($brands) ? $brands : $defaultBrands;

    // Duplicate brands untuk efek infinite scroll yang mulus
    $marqueeBrands = array_merge($brands, $brands, $brands);

    $speedClass = match($speed) {
        'normal' => 'animate-marquee-normal',
        'fast' => 'animate-marquee-fast',
        default => 'animate-marquee-slow',
    };

    $bgClass = match($background) {
        'gradient' => 'bg-gradient-to-r from-black via-gray-950 to-black',
        'transparent' => 'bg-transparent',
        default => 'bg-black',
    };

    // Adjust vertical padding when using transparent background to make sections tighter
    $sectionPadding = $background === 'transparent' ? 'py-12' : 'py-16 lg:py-20';
@endphp

<section class="relative {{ $sectionPadding }} {{ $bgClass }} overflow-hidden border-t border-white/5">
    
    {{-- Section Header --}}
    @if($title)
        <div class="text-center mb-12 lg:mb-16" data-aos="fade-up">
            <h2 class="text-2xl lg:text-3xl font-bold tracking-[0.1em] mb-2">
                {{ $title }}
            </h2>
            <div class="w-16 h-px bg-white/10 mx-auto"></div>
            @if($subtitle)
                <p class="text-white/40 text-sm mt-4 tracking-wider">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    @endif
    
    {{-- Marquee Container --}}
    <div class="relative max-w-[1800px] mx-auto">
        
        {{-- Gradient Overlay Kiri --}}
        @if($showGradient)
            <div class="absolute left-0 top-0 bottom-0 w-32 lg:w-48 z-10 bg-gradient-to-r from-black to-transparent pointer-events-none"></div>
        @endif
        
        {{-- Gradient Overlay Kanan --}}
        @if($showGradient)
            <div class="absolute right-0 top-0 bottom-0 w-32 lg:w-48 z-10 bg-gradient-to-l from-black to-transparent pointer-events-none"></div>
        @endif
        
        {{-- Marquee Track --}}
        <div class="marquee-container overflow-hidden"
             @if($pauseOnHover)
             x-data="{ paused: false }"
             @mouseenter="paused = true"
             @mouseleave="paused = false"
             @endif>
            
            {{-- Marquee Content (3x brands untuk infinite loop) --}}
            <div class="marquee-track flex items-center gap-12 lg:gap-20"
                 :class="{ 'pause-animation': paused }">
                
                @foreach($marqueeBrands as $index => $brand)
                    @php 
                        $brand = is_array($brand) ? (object) $brand : $brand;
                        $hasUrl = isset($brand->url) && !empty($brand->url);
                        $brandName = $brand->name ?? 'Brand';
                    @endphp
                    
                    @if($hasUrl)
                        <a href="{{ $brand->url }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="marquee-item flex-shrink-0 group cursor-pointer"
                           title="Visit {{ $brandName }} website">
                    @else
                        <div class="marquee-item flex-shrink-0 group cursor-default"
                             title="{{ $brandName }}">
                    @endif
                    
                        @if(isset($brand->logo) && $brand->logo)
                            {{-- Brand Logo --}}
                            <img src="{{ $brand->logo }}" 
                                 alt="{{ $brandName }}" 
                                 class="h-10 lg:h-14 w-auto opacity-40 group-hover:opacity-95 transition-all duration-400 filter grayscale group-hover:grayscale-0"
                                 loading="lazy">
                        @else
                            {{-- Brand Name (Text Only) --}}
                            <div class="flex items-center">
                                <span class="text-xl lg:text-2xl font-bold tracking-[0.2em] text-white/30 group-hover:text-white/60 transition-all duration-400 whitespace-nowrap">
                                    {{ $brandName }}
                                </span>
                                
                                {{-- External Link Icon (muncul saat hover jika ada URL) --}}
                                @if($hasUrl)
                                    <svg class="w-3.5 h-3.5 ml-2 text-white/0 group-hover:text-white/40 transition-all duration-400" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                @endif
                            </div>
                        @endif
                    
                    @if($hasUrl)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
                
            </div>
        </div>
    </div>
    
    {{-- Bottom Line Decoration --}}
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
</section>

{{-- Marquee Animation Styles --}}
@push('styles')
<style>
    /* Marquee Container */
    .marquee-container {
        position: relative;
        width: 100%;
    }
    
    /* Marquee Track */
    .marquee-track {
        display: flex;
        width: max-content;
        animation-play-state: running;
    }
    
    /* Pause on hover */
    .marquee-track.pause-animation {
        animation-play-state: paused !important;
    }
    
    /* Marquee Items */
    .marquee-item {
        transition: all 0.5s ease;
        text-decoration: none;
        outline: none;
    }
    
    .marquee-item:focus-visible {
        outline: 2px solid rgba(255, 255, 255, 0.3);
        outline-offset: 8px;
        border-radius: 4px;
    }
    
    /* Animation Keyframes */
    @keyframes marqueeScroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-33.333%); /* Geser 1/3 karena 3 set brands */
        }
    }
    
    /* Speed Variants */
    .animate-marquee-slow {
        animation: marqueeScroll 60s linear infinite;
    }
    
    .animate-marquee-normal {
        animation: marqueeScroll 40s linear infinite;
    }
    
    .animate-marquee-fast {
        animation: marqueeScroll 25s linear infinite;
    }
    
    /* Smooth rendering */
    .marquee-track {
        -webkit-font-smoothing: antialiased;
        backface-visibility: hidden;
        transform: translateZ(0);
        will-change: transform;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .animate-marquee-slow {
            animation-duration: 40s;
        }
        .animate-marquee-normal {
            animation-duration: 25s;
        }
        .animate-marquee-fast {
            animation-duration: 15s;
        }
    }
    
    /* Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        .marquee-track {
            animation: none !important;
        }
    }
</style>
@endpush