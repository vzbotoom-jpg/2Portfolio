{{-- resources/views/components/sections/stats-section.blade.php --}}
@props([
    'stats' => [],
    'background' => 'gradient', // gradient, solid, transparent
])

@php
    $bgClass = match($background) {
        'solid' => 'bg-black',
        'transparent' => 'bg-transparent',
        default => 'bg-gradient-to-b from-black via-gray-950 to-black',
    };
    
    $defaultStats = [
        ['number' => '50+', 'label' => 'PROJECTS COMPLETED', 'icon' => 'code'],
        ['number' => '5+', 'label' => 'YEARS EXPERIENCE', 'icon' => 'clock'],
        ['number' => '30+', 'label' => 'HAPPY CLIENTS', 'icon' => 'users'],
        ['number' => '15+', 'label' => 'TECHNOLOGIES', 'icon' => 'cpu'],
    ];
    
    $stats = !empty($stats) ? $stats : $defaultStats;
@endphp

<section class="relative py-24 lg:py-32 {{ $bgClass }} overflow-hidden">
    
    {{-- Background Grid Pattern --}}
    <div class="absolute inset-0 opacity-[0.02]">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>
    
    <div class="relative z-10 max-w-[1400px] mx-auto px-6 lg:px-16">
        
        {{-- Section Header (Optional) --}}
        <div class="text-center mb-16 lg:mb-20" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold tracking-[0.05em] mb-4">
                BY THE NUMBERS
            </h2>
            <div class="w-16 h-px bg-white/20 mx-auto"></div>
        </div>
        
        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            @foreach($stats as $index => $stat)
                @php
                    $icons = [
                        'code' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>',
                        'clock' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                        'users' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                        'cpu' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>',
                    ];
                    $icon = $icons[$stat['icon'] ?? 'code'] ?? $icons['code'];
                @endphp
                
                <x-ui.stat-item 
                    :number="$stat['number']" 
                    :label="$stat['label']"
                    :icon="$icon"
                    :description="$stat['description'] ?? null"
                    :animated="true"
                    :data-aos="'fade-up'"
                    :data-aos-delay="$index * 100"
                />
            @endforeach
        </div>
    </div>
</section>