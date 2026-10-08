{{-- resources/views/pages/service-detail.blade.php --}}
@extends('layouts.app')

@section('title', $service->title ?? 'Service Detail')
@section('meta_description', $service->short_description ?? Str::limit($service->description ?? '', 160))

@section('content')
@php
// Normalize service data to handle both Eloquent object and array formats
if ($service instanceof \App\Models\Service) {
    $serviceData = (object) [
        'title' => $service->title,
        'slug' => $service->slug,
        'excerpt' => $service->short_description ?? Str::limit($service->description, 160),
        'description' => $service->description,
        'icon' => $service->icon ?? 'globe',
        'features' => is_array($service->features) ? $service->features : [],
        'process' => is_array($service->process_steps) ? $service->process_steps : [],
        'pricing_start' => $service->pricing_start,
        'pricing_unit' => $service->pricing_unit ?? 'project',
        'image' => $service->image ? asset('storage/' . $service->image) : null,
    ];
} else {
    // Array format (fallback/hardcoded)
    $serviceData = (object) $service;
    $serviceData->slug = $serviceData->slug ?? $slug ?? null;
    $serviceData->excerpt = $serviceData->excerpt ?? Str::limit($serviceData->description ?? '', 160);
    $serviceData->process = $serviceData->process ?? [];
    $serviceData->features = $serviceData->features ?? [];
    $serviceData->pricing_start = $serviceData->pricing_start ?? null;
    $serviceData->pricing_unit = $serviceData->pricing_unit ?? 'project';
    $serviceData->image = $serviceData->image ?? null;
}

// Normalize allServices to handle both formats
$allServicesNormalized = collect();
if ($allServices instanceof \Illuminate\Database\Eloquent\Collection) {
    $allServicesNormalized = $allServices->map(function ($s) {
        return (object) [
            'title' => $s->title,
            'slug' => $s->slug,
            'excerpt' => $s->short_description ?? Str::limit($s->description, 100),
            'icon' => $s->icon ?? 'globe',
        ];
    });
} else {
    // Array format: [$slug => $service]
    $allServicesNormalized = collect($allServices)->map(function ($s, $slug) {
        $s = (object) $s;
        $s->slug = $s->slug ?? $slug;
        $s->excerpt = $s->excerpt ?? Str::limit($s->description ?? '', 100);
        return $s;
    });
}

// Icon mapping
$icons = [
    'globe' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
    'smartphone' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
    'palette' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>',
    'briefcase' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
    'server' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12H3m18 0h-2m2 0a2 2 0 11-4 0 2 2 0 014 0zM5 12a2 2 0 11-4 0 2 2 0 014 0zm14 0a2 2 0 11-4 0 2 2 0 014 0zM5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>',
    'code' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>',
];
$icon = $icons[$serviceData->icon ?? 'globe'] ?? $icons['globe'];
@endphp

{{-- Hero --}}
<section class="pt-40 pb-20 lg:pt-48 lg:pb-28 px-6 lg:px-16 bg-black relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.02]">
        <div class="absolute inset-0" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 100px 100px;"></div>
    </div>
    <div class="max-w-[1000px] mx-auto relative z-10" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <div class="flex items-center space-x-2 text-xs tracking-[0.2em] text-white/30 mb-8">
            <a href="{{ route('services') }}" class="hover:text-white transition-colors duration-300">SERVICES</a>
            <span>/</span>
            <span class="text-white/60">{{ strtoupper($serviceData->title) }}</span>
        </div>
        
        {{-- Icon --}}
        <div class="w-16 h-16 border border-white/10 rounded-full flex items-center justify-center text-white/60 mb-8">
            {!! $icon !!}
        </div>
        
        {{-- Title --}}
        <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6">
            {{ $serviceData->title }}
        </h1>
        
        {{-- Excerpt --}}
        <p class="text-white/50 text-lg leading-relaxed max-w-2xl">
            {{ $serviceData->excerpt }}
        </p>
    </div>
</section>

{{-- Description + Features --}}
<section class="py-20 lg:py-28 px-6 lg:px-16 bg-black">
    <div class="max-w-[1000px] mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
        <div class="lg:col-span-2" data-aos="fade-up">
            {{-- Full Description --}}
            <p class="text-white/60 text-base leading-relaxed">
                {{ $serviceData->description }}
            </p>
            
            {{-- Process Steps --}}
            @if(!empty($serviceData->process))
                <div class="mt-16">
                    <h2 class="text-xl font-bold tracking-wider mb-8">HOW IT WORKS</h2>
                    <div class="space-y-8">
                        @foreach($serviceData->process as $index => $step)
                            @php
                                // Handle both array and object step formats
                                $step = (object) $step;
                                $stepTitle = $step->title ?? '';
                                $stepDescription = $step->description ?? '';
                            @endphp
                            <div class="flex space-x-6">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-sm text-white/40">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 border-l border-white/5 pl-6 pb-2">
                                    <h3 class="text-base font-bold tracking-wide mb-1">{{ $stepTitle }}</h3>
                                    <p class="text-sm text-white/40">{{ $stepDescription }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        {{-- Sidebar: features + CTA --}}
        <div data-aos="fade-up" data-aos-delay="150">
            @if(!empty($serviceData->features))
                <div class="border border-white/5 p-8">
                    <h3 class="text-xs tracking-[0.3em] text-white/30 mb-6">WHAT'S INCLUDED</h3>
                    <ul class="space-y-3">
                        @foreach($serviceData->features as $feature)
                            <li class="flex items-center text-sm text-white/60">
                                <svg class="w-4 h-4 mr-3 text-white/20 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-8">
                        <x-ui.button
                            href="{{ route('contact.index') }}"
                            variant="filled"
                            size="md"
                            full-width="true">
                            GET IN TOUCH
                        </x-ui.button>
                    </div>
                </div>
            @endif
            
            {{-- Pricing (if available) --}}
            @if($serviceData->pricing_start)
                <div class="border border-white/5 p-8 mt-6">
                    <h3 class="text-xs tracking-[0.3em] text-white/30 mb-4">PRICING</h3>
                    <div class="text-2xl font-bold text-white mb-1">
                        ${{ number_format($serviceData->pricing_start, 0) }}
                        <span class="text-sm font-normal text-white/40">/ {{ $serviceData->pricing_unit }}</span>
                    </div>
                    <p class="text-xs text-white/30">Starting price. Contact for custom quote.</p>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Other Services --}}
@if($allServicesNormalized->count() > 0)
    <section class="py-20 lg:py-28 px-6 lg:px-16 bg-black border-t border-white/5">
        <div class="max-w-[1000px] mx-auto">
            <h2 class="text-xs tracking-[0.3em] text-white/30 mb-10">OTHER SERVICES</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($allServicesNormalized as $otherService)
                    @if(($otherService->slug ?? '') !== ($serviceData->slug ?? ''))
                        <a href="{{ route('services.show', $otherService->slug) }}"
                           class="group block p-6 border border-white/5 hover:border-white/20 transition-all duration-300">
                            <h3 class="text-sm font-bold tracking-wide mb-2 group-hover:text-white">
                                {{ $otherService->title }}
                            </h3>
                            <p class="text-xs text-white/30 line-clamp-2">
                                {{ $otherService->excerpt }}
                            </p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection