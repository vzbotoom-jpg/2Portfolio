{{-- resources/views/layouts/partials/navbar.blade.php --}}
@props([
    'logo' => 'THELUXS.DEV',
    'logoImage' => null,
    'navItems' => null,
    'transparent' => true,
    'showCta' => true,
    'ctaText' => 'HIRE ME',
    'ctaLink' => null,
    'sticky' => true,
    'variant' => 'default'
])

@php
    $navItems = $navItems ?? [
        ['label' => 'PROJECTS', 'url' => route('projects.index'), 'active' => request()->routeIs('projects.*')],
        ['label' => 'ABOUT', 'url' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => 'SERVICES', 'url' => route('services'), 'active' => request()->routeIs('services')],
        ['label' => 'CONTACT', 'url' => route('contact.index'), 'active' => request()->routeIs('contact.*')],
    ];
    
    $ctaLink = $ctaLink ?? route('contact.index');
@endphp

<nav x-data="{ 
    isOpen: false, 
    scrolled: false,
    lastScroll: 0,
    visible: true,
    activeDropdown: null
}" 
x-init="
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        scrolled = currentScroll > 50;
        
        // Hide/show on scroll
        if (currentScroll > 100) {
            visible = currentScroll < lastScroll;
        } else {
            visible = true;
        }
        
        lastScroll = currentScroll;
    });
    
    // Close mobile menu on resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            isOpen = false;
        }
    });
    
    // Close mobile menu on escape
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            isOpen = false;
            activeDropdown = null;
        }
    });
"
@click.outside="isOpen = false; activeDropdown = null"
:class="{
    'bg-black/90 backdrop-blur-xl shadow-2xl shadow-black/50': scrolled,
    'bg-transparent': !scrolled && {{ $transparent ? 'true' : 'false' }},
    'bg-black': !{{ $transparent ? 'true' : 'false' }},
    '-translate-y-full': !visible && {{ $sticky ? 'true' : 'false' }},
    'translate-y-0': visible
}"
class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 ease-out">

<div class="max-w-[1800px] mx-auto px-6 lg:px-12 xl:px-16">
    <div class="flex items-center justify-between h-20 lg:h-24">
        
        {{-- Logo --}}
        <a href="{{ route('home') }}" 
           class="relative group flex items-center space-x-3"
           aria-label="Home">
            @if($logoImage)
                <img src="{{ asset($logoImage) }}" 
                     alt="Logo" 
                     class="h-8 w-auto"
                     width="32"
                     height="32">
            @endif
            <span class="text-white font-bold text-xl lg:text-2xl tracking-[0.3em] transition-all duration-300 group-hover:text-white/80">
                {{ $logo }}
            </span>
            <span class="absolute -bottom-1 left-0 w-0 h-px bg-white transition-all duration-500 group-hover:w-full"></span>
        </a>
        
        {{-- Desktop Navigation --}}
        <div class="hidden lg:flex items-center space-x-1">
            @foreach($navItems as $index => $item)
                @php
                    $isActive = $item['active'] ?? false;
                    $hasChildren = !empty($item['children']);
                @endphp
                
                <div class="relative"
                     @mouseenter="activeDropdown = {{ $index }}"
                     @mouseleave="activeDropdown = null">
                    
                    <a href="{{ $item['url'] }}" 
                       class="relative px-4 py-2 text-sm tracking-[0.2em] font-medium transition-all duration-300 group flex items-center space-x-1
                              {{ $isActive ? 'text-white' : 'text-white/70 hover:text-white' }}"
                       @click="activeDropdown = {{ $hasChildren ? $index : 'null' }}">
                        <span>{{ $item['label'] }}</span>
                        
                        @if($hasChildren)
                            <svg class="w-4 h-4 ml-1 transition-transform duration-300" 
                                 :class="{ 'rotate-180': activeDropdown === {{ $index }} }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        @endif
                        
                        {{-- Active/Hover Indicator --}}
                        <span class="absolute bottom-0 left-4 right-4 h-px bg-white transform origin-left transition-all duration-300
                                   {{ $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}">
                        </span>
                    </a>
                    
                    {{-- Dropdown Menu --}}
                    @if($hasChildren)
                        <div x-show="activeDropdown === {{ $index }}"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute top-full left-0 mt-2 w-48 bg-black/95 backdrop-blur-xl border border-white/10 rounded-lg shadow-2xl py-2"
                             style="display: none;">
                            @foreach($item['children'] as $child)
                                <a href="{{ $child['url'] }}" 
                                   class="block px-4 py-2 text-sm text-white/70 hover:text-white hover:bg-white/5 transition-all duration-200">
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            
            {{-- CTA Button --}}
            @if($showCta)
                <div class="ml-8 pl-8 border-l border-white/10">
                    <a href="{{ $ctaLink }}" 
                       class="relative inline-flex items-center px-8 py-3 text-sm tracking-[0.2em] font-medium text-white border border-white/30 overflow-hidden group transition-all duration-500 hover:border-white">
                        <span class="relative z-10 transition-colors duration-500 group-hover:text-black">
                            {{ $ctaText }}
                        </span>
                        <div class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out"></div>
                        <svg class="relative z-10 w-4 h-4 ml-2 transform transition-all duration-500 group-hover:translate-x-1 group-hover:text-black" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
        
        {{-- Mobile Menu Button --}}
        <button @click="isOpen = !isOpen" 
                class="lg:hidden relative w-10 h-10 flex items-center justify-center focus:outline-none group"
                aria-label="Toggle menu"
                :aria-expanded="isOpen">
            <div class="relative w-6 h-5">
                <span class="absolute left-0 top-0 w-full h-px bg-white transform transition-all duration-300 origin-center"
                      :class="{ 'rotate-45 translate-y-2': isOpen }"></span>
                <span class="absolute left-0 top-2 w-full h-px bg-white transition-all duration-300"
                      :class="{ 'opacity-0 scale-x-0': isOpen }"></span>
                <span class="absolute left-0 bottom-0 w-full h-px bg-white transform transition-all duration-300 origin-center"
                      :class="{ '-rotate-45 -translate-y-2': isOpen }"></span>
            </div>
        </button>
    </div>
    
    {{-- Mobile Menu --}}
    @include('layouts.partials.mobile-menu')
</div>
</nav>