{{-- resources/views/components/sections/hero-section.blade.php --}}
@props([
    'title' => 'CREATING THE FUTURE',
    'subtitle' => 'Full-Stack Developer & Digital Architect',
    'description' => null,
    'backgroundImage' => null,
    'backgroundVideo' => null,
    'overlayOpacity' => 0.5,
    'primaryCta' => null,
    'secondaryCta' => null,
    'showScrollIndicator' => true,
    'particles' => false,
    'height' => 'screen',
    'alignment' => 'center',
])

@php
    $heightClass = match($height) {
        'full' => 'min-h-full',
        'auto' => 'min-h-auto',
        default => 'min-h-screen',
    };
    
    $alignmentClass = match($alignment) {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center',
    };
    
    $primaryCta = $primaryCta ?? [
        'text' => 'VIEW PROJECTS',
        'link' => route('projects.index'),
    ];
    
    $secondaryCta = $secondaryCta ?? [
        'text' => 'LEARN MORE',
        'link' => route('about'),
    ];
    
    $backgroundImage = $backgroundImage ?? asset('images/hero/hero-bg.webp');
@endphp

<section class="relative {{ $heightClass }} flex items-center justify-center overflow-hidden">
    
    {{-- Background Layer --}}
    <div class="absolute inset-0 z-0">
        @if($backgroundVideo)
            {{-- Video Background --}}
            <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                <source src="{{ asset($backgroundVideo) }}" type="video/mp4">
                <source src="{{ str_replace('.mp4', '.webm', asset($backgroundVideo)) }}" type="video/webm">
            </video>
        @else
                  {{-- Image Background (responsive) --}}
                  <picture>
                     <source media="(max-width:640px)" srcset="{{ asset('images/hero/hero.bg.mobile.webp') }}" type="image/webp">
                     <img src="{{ $backgroundImage }}" 
                         alt="Hero Background" 
                         class="absolute inset-0 w-full h-full object-cover"
                         fetchpriority="high">
                  </picture>
        @endif
        
        {{-- Dark Overlay --}}
        <div class="absolute inset-0 bg-black" style="opacity: {{ $overlayOpacity }}"></div>
        
        {{-- Gradient Overlay Bottom --}}
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-black to-transparent"></div>
        
        {{-- Gradient Overlay Top --}}
        <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-black/30 to-transparent"></div>
    </div>
    
    {{-- Particles Effect (Optional) --}}
    @if($particles)
        <div id="particles-js" class="absolute inset-0 z-10"></div>
    @endif
    
    {{-- Content --}}
    <div class="relative z-20 px-6 lg:px-16 max-w-[1400px] mx-auto w-full">
        <div class="flex flex-col {{ $alignmentClass }} py-20 lg:py-32">
            
            {{-- Subtitle (Optional, displayed above title) --}}
            @if($subtitle)
                <p class="text-sm md:text-base lg:text-lg text-white/60 tracking-[0.3em] mb-6 animate-fade-in-up"
                   data-aos="fade-up"
                   data-aos-delay="200">
                    {{ $subtitle }}
                </p>
            @endif
            
            {{-- Main Title --}}
            <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl xl:text-9xl font-bold tracking-[0.02em] leading-[0.9] mb-8 animate-fade-in-up"
                data-aos="fade-up"
                data-aos-delay="400">
                <span class="bg-gradient-to-b from-white to-white/40 bg-clip-text text-transparent">
                    {{ $title }}
                </span>
            </h1>
            
            {{-- Description --}}
            @if($description)
                <p class="text-sm md:text-base text-white/40 max-w-2xl mb-12 animate-fade-in-up leading-relaxed"
                   data-aos="fade-up"
                   data-aos-delay="600">
                    {{ $description }}
                </p>
            @endif
            
            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 animate-fade-in-up"
                 data-aos="fade-up"
                 data-aos-delay="800">
                
                {{-- Primary CTA --}}
                @if($primaryCta)
                    <x-ui.button 
                        :href="$primaryCta['link']" 
                        variant="outline" 
                        size="lg"
                        animated="true"
                        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>'
                        icon-position="right">
                        {{ $primaryCta['text'] }}
                    </x-ui.button>
                @endif
                
                {{-- Secondary CTA --}}
                @if($secondaryCta)
                    <x-ui.button 
                        :href="$secondaryCta['link']" 
                        variant="ghost" 
                        size="lg"
                        animated="false">
                        {{ $secondaryCta['text'] }}
                    </x-ui.button>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Scroll Indicator --}}
    @if($showScrollIndicator)
        <div class="absolute bottom-8 lg:bottom-12 left-1/2 transform -translate-x-1/2 z-20 animate-bounce-slow">
            <div class="flex flex-col items-center space-y-2 text-white/30">
                <span class="text-[10px] tracking-[0.5em]">SCROLL</span>
                <div class="w-px h-12 lg:h-16 bg-gradient-to-b from-white/40 to-transparent"></div>
            </div>
        </div>
    @endif
    
    {{-- Corner Decorations --}}
    <div class="absolute top-0 left-0 w-32 h-32 border-l border-t border-white/5 z-10 hidden lg:block"></div>
    <div class="absolute top-0 right-0 w-32 h-32 border-r border-t border-white/5 z-10 hidden lg:block"></div>
    <div class="absolute bottom-0 left-0 w-32 h-32 border-l border-b border-white/5 z-10 hidden lg:block"></div>
    <div class="absolute bottom-0 right-0 w-32 h-32 border-r border-b border-white/5 z-10 hidden lg:block"></div>
</section>

@push('styles')
<style>
    @keyframes bounce-slow {
        0%, 100% {
            transform: translate(-50%, 0);
        }
        50% {
            transform: translate(-50%, -10px);
        }
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 1s ease-out forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush