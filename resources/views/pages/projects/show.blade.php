{{-- resources/views/pages/projects/show.blade.php --}}
@extends('layouts.app')

@section('title', $project->title ?? 'Project Detail')
@section('meta_description', $project->description ?? 'Project detail page')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-[60vh] lg:h-[70vh] flex items-end overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            @php
                $projectImage = null;
                if (isset($project->image_url)) {
                    $projectImage = $project->image_url;
                } elseif (isset($project->image)) {
                    $projectImage = Str::startsWith($project->image, 'http') 
                        ? $project->image 
                        : asset('storage/' . $project->image);
                } else {
                    $projectImage = asset('images/projects/placeholder.webp');
                }
            @endphp
            <img src="{{ $projectImage }}" 
                 alt="{{ $project->title ?? 'Project' }}" 
                 class="w-full h-full object-cover"
                 loading="eager">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
        </div>
        
        {{-- Content --}}
        <div class="relative z-10 w-full pb-16 lg:pb-20 px-6 lg:px-16">
            <div class="max-w-[1400px] mx-auto">
                <div class="max-w-4xl" data-aos="fade-up">
                    <span class="text-xs tracking-[0.3em] text-white/50 mb-4 block">
                        {{ $project->category ?? 'PROJECT' }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-wider mb-6">
                        {{ $project->title ?? 'Untitled Project' }}
                    </h1>
                    @if(isset($project->short_description) && $project->short_description)
                        <p class="text-lg text-white/60 max-w-2xl">
                            {{ $project->short_description }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    
    {{-- Project Info Bar --}}
    <section class="py-8 lg:py-10 px-6 lg:px-16 bg-black border-b border-white/5">
        <div class="max-w-[1400px] mx-auto">
            <div class="flex flex-wrap gap-6 lg:gap-12 items-center text-sm">
                @if(isset($project->client) && $project->client)
                    <div>
                        <span class="text-white/30 text-xs tracking-[0.2em]">CLIENT</span>
                        <p class="text-white/70 mt-1">{{ $project->client }}</p>
                    </div>
                @endif
                
                @if(isset($project->duration) && $project->duration)
                    <div>
                        <span class="text-white/30 text-xs tracking-[0.2em]">DURATION</span>
                        <p class="text-white/70 mt-1">{{ $project->duration }}</p>
                    </div>
                @endif
                
                @if(isset($project->completed_at) && $project->completed_at)
                    <div>
                        <span class="text-white/30 text-xs tracking-[0.2em]">COMPLETED</span>
                        <p class="text-white/70 mt-1">
                            @if($project->completed_at instanceof \Carbon\Carbon)
                                {{ $project->completed_at->format('F Y') }}
                            @else
                                {{ $project->completed_at }}
                            @endif
                        </p>
                    </div>
                @endif
                
                {{-- Links --}}
                <div class="flex gap-4 ml-auto">
                    @if(isset($project->live_url) && $project->live_url)
                        <a href="{{ $project->live_url }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="flex items-center space-x-2 px-6 py-2.5 border border-white/20 text-white text-xs tracking-[0.2em] hover:bg-white hover:text-black transition-all duration-300">
                            <span>LIVE SITE</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                    
                    @if(isset($project->github_url) && $project->github_url)
                        <a href="{{ $project->github_url }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="flex items-center space-x-2 px-6 py-2.5 border border-white/10 text-white/60 text-xs tracking-[0.2em] hover:border-white/30 hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span>SOURCE CODE</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    
    {{-- Project Content --}}
    <section class="py-16 lg:py-24 px-6 lg:px-16 bg-black">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 lg:gap-24">
                
                {{-- Main Content --}}
                <div class="lg:col-span-2" data-aos="fade-up">
                    {{-- Description --}}
                    @if(isset($project->description) && $project->description)
                        <div class="mb-16">
                            <h3 class="text-xl tracking-[0.2em] font-bold mb-6">OVERVIEW</h3>
                            <p class="text-white/60 leading-relaxed">
                                {{ $project->description }}
                            </p>
                        </div>
                    @endif
                    
                    {{-- Challenges --}}
                    @if(isset($project->challenges) && $project->challenges)
                        <div class="mb-16">
                            <h3 class="text-xl tracking-[0.2em] font-bold mb-6">CHALLENGES</h3>
                            <p class="text-white/60 leading-relaxed">
                                {{ $project->challenges }}
                            </p>
                        </div>
                    @endif
                    
                    {{-- Solutions --}}
                    @if(isset($project->solutions) && $project->solutions)
                        <div class="mb-16">
                            <h3 class="text-xl tracking-[0.2em] font-bold mb-6">SOLUTIONS</h3>
                            <p class="text-white/60 leading-relaxed">
                                {{ $project->solutions }}
                            </p>
                        </div>
                    @endif
                    
                    {{-- Results --}}
                    @if(isset($project->results) && $project->results)
                        <div class="mb-16">
                            <h3 class="text-xl tracking-[0.2em] font-bold mb-6">RESULTS</h3>
                            <p class="text-white/60 leading-relaxed">
                                {{ $project->results }}
                            </p>
                        </div>
                    @endif
                    
                    {{-- Image Gallery --}}
                    @if(isset($project->gallery) && !empty($project->gallery))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-12">
                            @foreach($project->gallery as $image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ is_string($image) ? asset('storage/' . $image) : $image }}" 
                                         alt="Project Gallery" 
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                                         loading="lazy">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                {{-- Sidebar --}}
                <div class="lg:col-span-1" data-aos="fade-left">
                    <div class="sticky top-28 space-y-10">
                        
                        {{-- Technologies Used --}}
                        @if(isset($project->technologies) && !empty($project->technologies))
                            <div class="p-8 border border-white/5 bg-white/[0.01]">
                                <h4 class="text-xs tracking-[0.3em] text-white/40 mb-6">TECHNOLOGIES</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($project->technologies as $tech)
                                        <span class="px-3 py-1.5 border border-white/10 rounded-full text-xs text-white/50 hover:border-white/30 hover:text-white/80 transition-all duration-300">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        {{-- Testimonial --}}
                        @if(isset($project->testimonial) && $project->testimonial)
                            <div class="p-8 border border-white/5 bg-white/[0.01]">
                                <h4 class="text-xs tracking-[0.3em] text-white/40 mb-6">TESTIMONIAL</h4>
                                <blockquote class="text-white/60 text-sm leading-relaxed mb-4 italic">
                                    "{{ $project->testimonial }}"
                                </blockquote>
                                @if(isset($project->testimonial_author) && $project->testimonial_author)
                                    <div class="flex items-center space-x-3 border-t border-white/5 pt-4">
                                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center">
                                            <span class="text-xs text-white/30">
                                                {{ strtoupper(substr($project->testimonial_author, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm text-white/70">{{ $project->testimonial_author }}</div>
                                            @if(isset($project->testimonial_position) && $project->testimonial_position)
                                                <div class="text-xs text-white/30">{{ $project->testimonial_position }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        {{-- Need a similar project? --}}
                        <div class="p-8 border border-white/10 bg-white/[0.02] text-center">
                            <h4 class="text-lg tracking-wider font-bold mb-4">NEED A SIMILAR PROJECT?</h4>
                            <p class="text-white/40 text-sm mb-6">Let's discuss how I can help you build something amazing.</p>
                            <a href="{{ route('contact.index') }}" 
                               class="block w-full relative overflow-hidden border border-white/30 text-white px-6 py-3 text-sm tracking-[0.2em] font-medium group transition-all duration-500 hover:bg-white hover:text-black">
                                <span class="relative z-10">GET IN TOUCH</span>
                                <div class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Navigation --}}
    <section class="py-12 px-6 lg:px-16 bg-black border-t border-white/5">
        <div class="max-w-[1400px] mx-auto">
            <div class="flex justify-between items-center">
                @if(isset($prevProject) && $prevProject)
                    <a href="{{ route('projects.show', $prevProject->slug) }}" 
                       class="group flex items-center space-x-3 text-white/40 hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-300" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <div>
                            <div class="text-xs tracking-[0.2em] text-white/20 mb-1">PREVIOUS</div>
                            <div class="text-sm">{{ $prevProject->title ?? 'Previous' }}</div>
                        </div>
                    </a>
                @else
                    <div></div>
                @endif
                
                <a href="{{ route('projects.index') }}" 
                   class="hidden sm:flex items-center space-x-2 text-white/40 hover:text-white transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span class="text-sm tracking-wider">ALL PROJECTS</span>
                </a>
                
                @if(isset($nextProject) && $nextProject)
                    <a href="{{ route('projects.show', $nextProject->slug) }}" 
                       class="group flex items-center space-x-3 text-right text-white/40 hover:text-white transition-colors duration-300">
                        <div>
                            <div class="text-xs tracking-[0.2em] text-white/20 mb-1">NEXT</div>
                            <div class="text-sm">{{ $nextProject->title ?? 'Next' }}</div>
                        </div>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <div></div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });
    </script>
@endpush