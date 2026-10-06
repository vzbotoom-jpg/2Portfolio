{{-- resources/views/pages/service-detail.blade.php --}}
@extends('layouts.app')

@section('title', $service['title'])
@section('meta_description', $service['excerpt'])

@section('content')

@php
    $icons = [
        'globe' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
        'smartphone' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
        'palette' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>',
    ];
    $icon = $icons[$service['icon'] ?? 'globe'] ?? $icons['globe'];
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
            <span class="text-white/60">{{ strtoupper($service['title']) }}</span>
        </div>

        <div class="w-16 h-16 border border-white/10 rounded-full flex items-center justify-center text-white/60 mb-8">
            {!! $icon !!}
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6">
            {{ $service['title'] }}
        </h1>
        <p class="text-white/50 text-lg leading-relaxed max-w-2xl">
            {{ $service['excerpt'] }}
        </p>
    </div>
</section>

{{-- Description + Features --}}
<section class="py-20 lg:py-28 px-6 lg:px-16 bg-black">
    <div class="max-w-[1000px] mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">

        <div class="lg:col-span-2" data-aos="fade-up">
            <p class="text-white/60 text-base leading-relaxed">
                {{ $service['description'] }}
            </p>

            @if(!empty($service['process']))
                <div class="mt-16">
                    <h2 class="text-xl font-bold tracking-wider mb-8">HOW IT WORKS</h2>
                    <div class="space-y-8">
                        @foreach($service['process'] as $index => $step)
                            <div class="flex space-x-6">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-sm text-white/40">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 border-l border-white/5 pl-6 pb-2">
                                    <h3 class="text-base font-bold tracking-wide mb-1">{{ $step['title'] }}</h3>
                                    <p class="text-sm text-white/40">{{ $step['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar: features + CTA --}}
        <div data-aos="fade-up" data-aos-delay="150">
            @if(!empty($service['features']))
                <div class="border border-white/5 p-8">
                    <h3 class="text-xs tracking-[0.3em] text-white/30 mb-6">WHAT'S INCLUDED</h3>
                    <ul class="space-y-3">
                        @foreach($service['features'] as $feature)
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
        </div>
    </div>
</section>

{{-- Other Services --}}
@if(!empty($allServices))
    <section class="py-20 lg:py-28 px-6 lg:px-16 bg-black border-t border-white/5">
        <div class="max-w-[1000px] mx-auto">
            <h2 class="text-xs tracking-[0.3em] text-white/30 mb-10">OTHER SERVICES</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($allServices as $otherSlug => $otherService)
                    @continue($otherSlug === $slug)
                    <a href="{{ route('services.show', ['slug' => $otherSlug]) }}"
                       class="group block p-6 border border-white/5 hover:border-white/20 transition-all duration-300">
                        <h3 class="text-sm font-bold tracking-wide mb-2 group-hover:text-white">
                            {{ $otherService['title'] }}
                        </h3>
                        <p class="text-xs text-white/30 line-clamp-2">
                            {{ $otherService['excerpt'] }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection