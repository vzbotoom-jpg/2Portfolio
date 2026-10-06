{{-- resources/views/components/sections/services-section.blade.php --}}
@props([
    'services' => [],
    'title' => 'SERVICES',
    'subtitle' => null,
])

@php
    $defaultServices = [
        [
            'title' => 'Web Development',
            'description' => 'Custom web applications built with cutting-edge technologies for optimal performance and scalability.',
            'icon' => 'globe',
            'features' => ['Responsive Design', 'SEO Optimized', 'Performance Focused']
        ],
        [
            'title' => 'Mobile Apps',
            'description' => 'Native and cross-platform mobile applications that deliver exceptional user experiences.',
            'icon' => 'smartphone',
            'features' => ['iOS & Android', 'Cross-Platform', 'Offline Support']
        ],
        [
            'title' => 'UI/UX Design',
            'description' => 'Beautiful and intuitive user interfaces crafted with meticulous attention to detail.',
            'icon' => 'palette',
            'features' => ['User Research', 'Prototyping', 'Design Systems']
        ],
    ];
    
    $services = !empty($services) ? $services : $defaultServices;
@endphp

<section id="services" class="py-24 lg:py-32 px-6 lg:px-16 bg-black">
    <div class="max-w-[1400px] mx-auto">
        
        {{-- Section Header --}}
        <div class="text-center mb-16 lg:mb-20" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-4">
                {{ $title }}
            </h2>
            <div class="w-24 h-px bg-white/20 mx-auto mb-6"></div>
            @if($subtitle)
                <p class="text-white/40 text-lg max-w-2xl mx-auto">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
        
        {{-- Services Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $index => $service)
                @php
                    $service = (object) $service;
                    $icons = [
                        'globe' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
                        'smartphone' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                        'palette' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>',
                    ];
                    $icon = $icons[$service->icon ?? 'globe'] ?? $icons['globe'];
                    $features = $service->features ?? [];
                @endphp
                
                <div class="group relative p-8 lg:p-10 border border-white/5 hover:border-white/20 transition-all duration-500 bg-gradient-to-b from-transparent to-white/[0.02]"
                     data-aos="fade-up"
                     data-aos-delay="{{ $index * 100 }}">
                    
                    {{-- Icon --}}
                    <div class="w-16 h-16 border border-white/10 rounded-full flex items-center justify-center text-white/40 group-hover:text-white group-hover:border-white/30 transition-all duration-500 mb-8 group-hover:scale-110">
                        {!! $icon !!}
                    </div>
                    
                    {{-- Title --}}
                    <h3 class="text-xl lg:text-2xl font-bold tracking-wider mb-4 group-hover:text-white transition-colors duration-300">
                        {{ $service->title }}
                    </h3>
                    
                    {{-- Description --}}
                    <p class="text-white/40 text-sm leading-relaxed mb-6">
                        {{ $service->description }}
                    </p>
                    
                    {{-- Features --}}
                    @if(!empty($features))
                        <ul class="space-y-3">
                            @foreach($features as $feature)
                                <li class="flex items-center text-sm text-white/30">
                                    <svg class="w-4 h-4 mr-3 text-white/20 group-hover:text-white/40 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    
                    {{-- Hover Line --}}
                    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>