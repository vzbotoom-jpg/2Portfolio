{{-- resources/views/components/sections/about-section.blade.php --}}
@props([
    'title' => 'ABOUT ME',
    'subtitle' => null,
    'bio' => [],
    'image' => null,
    'skills' => [],
])

@php
    $image = $image ?? asset('images/about/profile.webp');
    
    $defaultBio = [
        [
            'year' => '2024',
            'title' => 'Senior Full-Stack Developer',
            'company' => 'Tech Company',
            'description' => 'Leading development of enterprise-level applications.'
        ],
        [
            'year' => '2022',
            'title' => 'Full-Stack Developer',
            'company' => 'Digital Agency',
            'description' => 'Developed multiple client projects using Laravel and Vue.js.'
        ],
        [
            'year' => '2020',
            'title' => 'Junior Developer',
            'company' => 'Startup Inc',
            'description' => 'Started career building web applications.'
        ],
    ];
    
    $bio = !empty($bio) ? $bio : $defaultBio;
@endphp

<section class="py-24 lg:py-32 px-6 lg:px-16 bg-black relative overflow-hidden">
    
    {{-- Background Grid --}}
    <div class="absolute inset-0 opacity-[0.02]">
        <div class="absolute inset-0" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 100px 100px;"></div>
    </div>
    
    <div class="max-w-[1400px] mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
            
            {{-- Left Column - Image --}}
            <div class="relative" data-aos="fade-right">
                <div class="relative aspect-[3/4] overflow-hidden">
                    <img src="{{ $image }}" 
                         alt="Profile" 
                         class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700"
                         loading="lazy">
                    
                    {{-- Decorative Frame --}}
                    <div class="absolute inset-4 border border-white/10 pointer-events-none"></div>
                    
                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                
                {{-- Experience Badge --}}
                <div class="absolute -bottom-6 -right-6 bg-white text-black px-8 py-6 hidden lg:block">
                    <div class="text-4xl font-bold">5+</div>
                    <div class="text-xs tracking-[0.3em] mt-1">YEARS EXP.</div>
                </div>
            </div>
            
            {{-- Right Column - Content --}}
            <div data-aos="fade-left">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6">
                    {{ $title }}
                </h2>
                <div class="w-24 h-px bg-white/20 mb-8"></div>
                
                @if($subtitle)
                    <p class="text-white/40 text-lg leading-relaxed mb-12">
                        {{ $subtitle }}
                    </p>
                @endif
                
                {{-- Timeline --}}
                <div class="space-y-8">
                    @foreach($bio as $index => $item)
                        @php $item = (object) $item; @endphp
                        <div class="flex space-x-6 group cursor-default"
                             data-aos="fade-up"
                             data-aos-delay="{{ $index * 100 }}">
                            
                            {{-- Year --}}
                            <div class="flex-shrink-0 w-16">
                                <span class="text-sm tracking-[0.3em] text-white/30 group-hover:text-white/60 transition-colors duration-300">
                                    {{ $item->year }}
                                </span>
                            </div>
                            
                            {{-- Content --}}
                            <div class="flex-1 border-l border-white/5 pl-6 pb-8 group-hover:border-white/20 transition-colors duration-300">
                                <h3 class="text-lg font-bold tracking-wider mb-1">
                                    {{ $item->title }}
                                </h3>
                                @if(isset($item->company))
                                    <p class="text-sm text-white/40 mb-2">{{ $item->company }}</p>
                                @endif
                                <p class="text-sm text-white/30 group-hover:text-white/50 transition-colors duration-300">
                                    {{ $item->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Download Resume Button --}}
                <div class="mt-12">
                    <x-ui.button 
                        href="#" 
                        variant="outline" 
                        size="md"
                        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'
                        icon-position="left">
                        DOWNLOAD RESUME
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</section>