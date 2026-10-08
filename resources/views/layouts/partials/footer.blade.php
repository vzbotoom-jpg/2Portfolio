{{-- resources/views/layouts/partials/footer.blade.php --}}
@props([
    'logo' => 'THELUXS.DEV',
    'description' => 'Building the future, one line of code at a time.',
    'sections' => null,
    'socialLinks' => null,
    'copyright' => null,
    'bottomText' => 'Not live yet',
    'showNewsletter' => false
])

@php
    $year = date('Y');
    $copyright = $copyright ?? "© {$year} THELUXS.DEV. ALL RIGHTS RESERVED.";
    
    $sections = $sections ?? [
        [
            'title' => 'NAVIGATION',
            'links' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Projects', 'url' => route('projects.index')],
                ['label' => 'About', 'url' => route('about')],
                ['label' => 'Services', 'url' => route('services')],
                ['label' => 'Testimonials', 'url' => route('home') . '#testimonials'],
                ['label' => 'Contact', 'url' => route('contact.index')],
            ]
        ],
        [
            'title' => 'SERVICES',
            'links' => [
                ['label' => 'Web Development', 'url' => route('services.show', ['slug' => 'web-development'])],
                ['label' => 'Mobile Apps', 'url' => route('services.show', ['slug' => 'mobile-apps'])],
                ['label' => 'UI/UX Design', 'url' => route('services.show', ['slug' => 'ui-ux-design'])],
                ['label' => 'Consulting', 'url' => route('services.show', ['slug' => 'consulting'])],
            ]
        ],
        [
            'title' => 'CONNECT',
            'links' => [
                ['label' => 'GitHub', 'url' => 'https://github.com/yourusername'],
                ['label' => 'LinkedIn', 'url' => 'https://linkedin.com/in/yourusername'],
                ['label' => 'Twitter', 'url' => 'https://twitter.com/yourusername'],
                ['label' => 'Dribbble', 'url' => 'https://dribbble.com/yourusername'],
                ['label' => 'Instagram', 'url' => 'https://instagram.com/yourusername'],
                ['label' => 'Email', 'url' => 'mailto:hello@yourdomain.com'],
            ]
        ],
    ];
    
    $socialLinks = $socialLinks ?? [
        'github' => 'https://github.com/yourusername',
        'linkedin' => 'https://linkedin.com/in/yourusername',
        'twitter' => 'https://twitter.com/yourusername',
        'dribbble' => 'https://dribbble.com/yourusername',
        'instagram' => 'https://instagram.com/yourusername',
    ];
@endphp

<footer class="relative bg-black border-t border-white/5">
    {{-- Top Gradient Line --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
    
    <div class="max-w-[1800px] mx-auto px-6 lg:px-12 xl:px-16">
        
        {{-- Main Footer Content --}}
        <div class="py-20 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                
                {{-- Brand Column --}}
                <div class="lg:col-span-5">
                    <a href="{{ route('home') }}" 
                       class="inline-block text-white font-bold text-2xl lg:text-3xl tracking-[0.3em] mb-6 hover:text-white/80 transition-colors duration-300">
                        {{ $logo }}
                    </a>
                    
                    <p class="text-white/40 text-base leading-relaxed max-w-md mb-8">
                        {{ $description }}
                    </p>
                    
                    {{-- Social Links --}}
                    <div class="flex items-center space-x-4">
                        @foreach($socialLinks as $platform => $url)
                            <a href="{{ $url }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="w-10 h-10 border border-white/10 rounded-full flex items-center justify-center text-white/40 hover:text-white hover:border-white/30 transition-all duration-300 hover:-translate-y-1"
                               aria-label="{{ ucfirst($platform) }}">
                                @if($platform === 'github')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                @elseif($platform === 'linkedin')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                @elseif($platform === 'twitter')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                @elseif($platform === 'dribbble')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.12-10.358c-.35-.11-3.17-.953-6.384-.438 1.34 3.684 1.887 6.684 1.992 7.308 2.3-1.555 3.936-4.02 4.395-6.87zm-6.115 7.808c-.153-.9-.75-4.032-2.19-7.77l-.066.02c-5.79 2.015-7.86 6.025-8.04 6.4 1.73 1.358 3.92 2.166 6.29 2.166 1.42 0 2.77-.29 4-.81zm-11.62-2.58c.232-.4 3.045-5.055 8.332-6.765.135-.045.27-.084.405-.12-.26-.585-.54-1.167-.832-1.74C7.17 11.775 2.206 11.71 1.756 11.7l-.004.312c0 2.633.998 5.037 2.634 6.855zm-2.42-8.955c.46.008 4.683.026 9.477-1.248-1.698-3.018-3.53-5.558-3.8-5.928-2.868 1.35-5.01 3.99-5.676 7.17zM9.6 2.052c.282.38 2.145 2.914 3.822 6 3.645-1.365 5.19-3.44 5.373-3.702-1.81-1.61-4.19-2.586-6.795-2.586-.825 0-1.63.1-2.4.29zm10.335 3.483c-.218.29-1.91 2.493-5.724 4.04.24.49.47.985.68 1.486.08.18.15.36.22.53 3.41-.43 6.8.26 7.14.33-.02-2.42-.88-4.64-2.31-6.38z"/>
                                    </svg>
                                @elseif($platform === 'instagram')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                @elseif($platform === 'email')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                
                {{-- Navigation Columns --}}
                <div class="lg:col-span-7">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 lg:gap-12">
                        @foreach($sections as $section)
                            <div>
                                <h4 class="text-xs tracking-[0.3em] text-white/50 mb-6 font-medium">
                                    {{ $section['title'] }}
                                </h4>
                                <ul class="space-y-3">
                                    @foreach($section['links'] as $link)
                                        <li>
                                            @php
                                                // Laravel's route() always returns an absolute URL
                                                // (https://yourdomain.com/...), so checking only for
                                                // an "http" prefix made every internal menu link look
                                                // external too. We now compare hosts directly: only
                                                // a different domain (or mailto:) counts as external.
                                                $linkUrl = $link['url'];
                                                $isMailto = Str::startsWith($linkUrl, 'mailto:');
                                                $isExternal = $isMailto || (
                                                    Str::startsWith($linkUrl, ['http://', 'https://'])
                                                    && parse_url($linkUrl, PHP_URL_HOST) !== parse_url(url('/'), PHP_URL_HOST)
                                                );
                                            @endphp
                                            <a href="{{ $linkUrl }}" 
                                               class="text-sm text-white/40 hover:text-white transition-all duration-300 hover:translate-x-1 inline-block"
                                               @if($isExternal)
                                                   target="_blank" 
                                                   rel="noopener noreferrer"
                                               @endif>
                                                {{ $link['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                        
                        {{-- Newsletter Section (Optional) --}}
                        @if($showNewsletter)
                            <div>
                                <h4 class="text-xs tracking-[0.3em] text-white/50 mb-6 font-medium">
                                    NEWSLETTER
                                </h4>
                                <p class="text-sm text-white/40 mb-4">
                                    Subscribe for updates and insights.
                                </p>
                                <form class="flex gap-2" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                                    <input type="email" 
                                           placeholder="Your email" 
                                           class="flex-1 bg-white/5 border border-white/10 rounded-none px-4 py-2 text-sm text-white placeholder-white/20 focus:outline-none focus:border-white/30 transition-colors">
                                    <button type="submit" 
                                            class="px-4 py-2 border border-white/20 text-white text-sm tracking-wider hover:bg-white hover:text-black transition-all duration-300">
                                        OK
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Bottom Bar --}}
        <div class="py-8 border-t border-white/5">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-6">
                    <p class="text-xs text-white/20 tracking-wider">
                        {{ $copyright }}
                    </p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <p class="text-xs text-white/20 tracking-wider">
                        {{ $bottomText }}
                    </p>
                    {{-- Back to Top --}}
                    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                            class="w-8 h-8 border border-white/10 rounded-full flex items-center justify-center text-white/40 hover:text-white hover:border-white/30 transition-all duration-300"
                            aria-label="Back to top">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>