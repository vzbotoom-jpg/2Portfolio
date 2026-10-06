{{-- resources/views/pages/projects/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Projects')
@section('meta_description', 'Explore my portfolio of web development projects, applications, and digital solutions.')

@section('content')
    {{-- Page Header --}}
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 px-6 lg:px-16 bg-black">
        <div class="max-w-[1400px] mx-auto">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold tracking-[0.05em] mb-6">
                    PROJECTS
                </h1>
                <div class="w-24 h-px bg-white/20 mx-auto mb-6"></div>
                <p class="text-white/40 text-lg max-w-2xl mx-auto">
                    A collection of projects that showcase my skills and experience in web development.
                </p>
            </div>
        </div>
    </section>
    
    {{-- Filters Section --}}
    <section class="py-8 px-6 lg:px-16 bg-black border-y border-white/5 sticky top-20 lg:top-24 z-30 backdrop-blur-xl bg-black/80">
        <div class="max-w-[1400px] mx-auto">
            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4 lg:items-center lg:justify-between">
                
                {{-- Search --}}
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search projects..." 
                               class="w-full bg-white/5 border border-white/10 px-4 py-3 pl-12 text-sm text-white placeholder-white/20 focus:outline-none focus:border-white/30 transition-colors">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 text-white/30" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                {{-- Filters --}}
                <div class="flex flex-wrap gap-3 lg:gap-4 items-center">
                    {{-- Category Filter --}}
                    <select name="category" 
                            class="bg-white/5 border border-white/10 px-4 py-3 text-sm text-white/60 focus:outline-none focus:border-white/30 cursor-pointer"
                            onchange="this.form.submit()">
                        <option value="" class="bg-black">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }} class="bg-black">
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    
                    {{-- Sort --}}
                    <select name="sort" 
                            class="bg-white/5 border border-white/10 px-4 py-3 text-sm text-white/60 focus:outline-none focus:border-white/30 cursor-pointer"
                            onchange="this.form.submit()">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }} class="bg-black">Latest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }} class="bg-black">Oldest</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }} class="bg-black">Name</option>
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }} class="bg-black">Featured</option>
                    </select>
                    
                    {{-- Clear Filters --}}
                    @if(request()->anyFilled(['search', 'category', 'sort']))
                        <a href="{{ route('projects.index') }}" 
                           class="text-xs text-white/40 hover:text-white transition-colors px-3 py-2">
                            Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>
    
    {{-- Projects Grid --}}
    <section class="py-16 lg:py-24 px-6 lg:px-16 bg-black">
        <div class="max-w-[1400px] mx-auto">
            
            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($projects as $index => $project)
                        @include('components.ui.project-card', [
                            'project' => $project,
                            'showCategory' => true,
                            'showExcerpt' => false,
                            'animated' => true,
                        ])
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                @if($projects->hasPages())
                    <div class="mt-16 lg:mt-20">
                        {{ $projects->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <svg class="w-16 h-16 text-white/10 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-xl font-bold tracking-wider mb-4">No Projects Found</h3>
                    <p class="text-white/40 mb-8">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('projects.index') }}" 
                       class="inline-block border border-white/30 text-white px-8 py-3 text-sm tracking-[0.2em] hover:bg-white hover:text-black transition-all duration-300">
                        VIEW ALL PROJECTS
                    </a>
                </div>
            @endif
        </div>
    </section>
    
    {{-- CTA Section --}}
    <section class="py-20 lg:py-28 px-6 lg:px-16 bg-gradient-to-b from-black to-gray-950 text-center">
        <div class="max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold tracking-[0.05em] mb-6">
                HAVE A PROJECT IN MIND?
            </h2>
            <p class="text-white/40 text-lg mb-10">
                Let's work together to bring your ideas to life. Get in touch and let's discuss your project.
            </p>
            <a href="{{ route('contact.index') }}" 
               class="relative inline-flex items-center justify-center px-10 py-4 text-sm tracking-[0.2em] font-medium text-white border border-white/30 overflow-hidden group transition-all duration-500 hover:border-white">
                <span class="relative z-10 transition-colors duration-500 group-hover:text-black">START A PROJECT</span>
                <div class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out"></div>
                <svg class="relative z-10 w-4 h-4 ml-2 transform transition-all duration-500 group-hover:translate-x-1 group-hover:text-black" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
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