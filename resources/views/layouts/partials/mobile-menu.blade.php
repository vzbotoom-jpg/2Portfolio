{{-- resources/views/layouts/partials/mobile-menu.blade.php --}}
<div x-show="isOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-4"
     x-trap.inert.noscroll="isOpen"
     class="lg:hidden fixed inset-x-0 top-20 bg-black/98 backdrop-blur-xl border-t border-white/5 overflow-y-auto"
     style="max-height: calc(100vh - 5rem); display: none;">
    
    <div class="px-6 py-8 space-y-2">
        @foreach($navItems as $index => $item)
            @php
                $isActive = $item['active'] ?? false;
                $hasChildren = !empty($item['children']);
            @endphp
            
            <div>
                @if($hasChildren)
                    <button @click="activeDropdown = activeDropdown === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between py-4 text-base tracking-[0.2em] transition-all duration-300
                                   {{ $isActive ? 'text-white' : 'text-white/70 hover:text-white' }}">
                        <span>{{ $item['label'] }}</span>
                        <svg class="w-4 h-4 transition-transform duration-300"
                             :class="{ 'rotate-180': activeDropdown === {{ $index }} }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="activeDropdown === {{ $index }}"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="pl-4 space-y-1 border-l border-white/10 ml-4"
                         style="display: none;">
                        @foreach($item['children'] as $child)
                            <a href="{{ $child['url'] }}" 
                               class="block py-3 text-sm text-white/60 hover:text-white transition-all duration-300 hover:translate-x-1"
                               @click="isOpen = false">
                                {{ $child['label'] }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <a href="{{ $item['url'] }}" 
                       class="flex items-center justify-between py-4 text-base tracking-[0.2em] transition-all duration-300 border-b border-white/5
                              {{ $isActive ? 'text-white' : 'text-white/70 hover:text-white hover:translate-x-2' }}"
                       @click="isOpen = false">
                        <span>{{ $item['label'] }}</span>
                        <svg class="w-4 h-4 opacity-0 transform -translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        @endforeach
        
        {{-- CTA Button in Mobile Menu --}}
        @if(isset($showCta) && $showCta)
            <div class="pt-6">
                <a href="{{ $ctaLink ?? route('contact.index') }}" 
                   class="block text-center border border-white/30 text-white px-8 py-4 text-sm tracking-[0.2em] font-medium hover:bg-white hover:text-black transition-all duration-300"
                   @click="isOpen = false">
                    {{ $ctaText ?? 'HIRE ME' }}
                </a>
            </div>
        @endif
        
        {{-- Social Links in Mobile Menu --}}
        <div class="pt-8 border-t border-white/5">
            <div class="flex items-center justify-center space-x-6">
                <a href="https://github.com/yourusername" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="text-white/40 hover:text-white transition-colors duration-300"
                   aria-label="GitHub">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
                <a href="https://linkedin.com/in/yourusername" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="text-white/40 hover:text-white transition-colors duration-300"
                   aria-label="LinkedIn">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                <a href="https://twitter.com/yourusername" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="text-white/40 hover:text-white transition-colors duration-300"
                   aria-label="Twitter">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a href="https://dribbble.com/yourusername" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="text-white/40 hover:text-white transition-colors duration-300"
                   aria-label="Dribbble">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.12-10.358c-.35-.11-3.17-.953-6.384-.438 1.34 3.684 1.887 6.684 1.992 7.308 2.3-1.555 3.936-4.02 4.395-6.87zm-6.115 7.808c-.153-.9-.75-4.032-2.19-7.77l-.066.02c-5.79 2.015-7.86 6.025-8.04 6.4 1.73 1.358 3.92 2.166 6.29 2.166 1.42 0 2.77-.29 4-.81zm-11.62-2.58c.232-.4 3.045-5.055 8.332-6.765.135-.045.27-.084.405-.12-.26-.585-.54-1.167-.832-1.74C7.17 11.775 2.206 11.71 1.756 11.7l-.004.312c0 2.633.998 5.037 2.634 6.855zm-2.42-8.955c.46.008 4.683.026 9.477-1.248-1.698-3.018-3.53-5.558-3.8-5.928-2.868 1.35-5.01 3.99-5.676 7.17zM9.6 2.052c.282.38 2.145 2.914 3.822 6 3.645-1.365 5.19-3.44 5.373-3.702-1.81-1.61-4.19-2.586-6.795-2.586-.825 0-1.63.1-2.4.29zm10.335 3.483c-.218.29-1.91 2.493-5.724 4.04.24.49.47.985.68 1.486.08.18.15.36.22.53 3.41-.43 6.8.26 7.14.33-.02-2.42-.88-4.64-2.31-6.38z"/>
                    </svg>
                </a>
                <a href="mailto:hello@yourdomain.com" 
                   class="text-white/40 hover:text-white transition-colors duration-300"
                   aria-label="Email">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </a>
            </div>
        </div>
        
        {{-- Copyright in Mobile Menu --}}
        <div class="pt-6 text-center">
            <p class="text-xs text-white/20 tracking-wider">
                &copy; {{ date('Y') }} {{ $logo ?? 'THELUXS' }}. All rights reserved.
            </p>
        </div>
    </div>
</div>