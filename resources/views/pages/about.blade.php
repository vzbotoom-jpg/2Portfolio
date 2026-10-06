{{-- resources/views/pages/about.blade.php --}}
@extends('layouts.app')

@section('title', 'About')
@section('meta_description', 'Learn more about my experience, skills, and journey as a full-stack developer.')

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 px-6 lg:px-16 bg-black overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/[0.01] rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="max-w-[1400px] mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
                {{-- Image --}}
                <div class="relative" data-aos="fade-right">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img src="{{ asset('images/about/profile.webp') }}" 
                             alt="Profile Photo" 
                             class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700"
                             loading="eager">
                        <div class="absolute inset-4 border border-white/10 pointer-events-none"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    </div>
                    
                    <div class="absolute -bottom-6 -right-6 bg-white text-black px-8 py-6 hidden lg:block z-20">
                        <div class="text-4xl font-bold">5+</div>
                        <div class="text-xs tracking-[0.3em] mt-1">YEARS EXP.</div>
                    </div>
                </div>
                
                {{-- Content --}}
                <div data-aos="fade-left">
                    <span class="text-xs tracking-[0.3em] text-white/30 mb-4 block">ABOUT ME</span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6 leading-[1.1]">
                        PASSIONATE<br>DEVELOPER &<br>PROBLEM SOLVER
                    </h1>
                    <div class="w-24 h-px bg-white/20 mb-8"></div>
                    
                    <div class="space-y-4 text-white/50 leading-relaxed">
                        <p>
                            I'm a full-stack developer with over 5 years of experience building 
                            innovative digital solutions. My passion lies in creating exceptional 
                            web experiences that combine beautiful design with powerful functionality.
                        </p>
                        <p>
                            I specialize in modern web technologies including Laravel, Vue.js, React, 
                            and Node.js. I'm dedicated to writing clean, efficient code and staying 
                            at the forefront of web development trends.
                        </p>
                        <p>
                            When I'm not coding, you can find me exploring new technologies, 
                            contributing to open-source projects, or sharing knowledge through 
                            technical writing and mentoring.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-8 mt-12 pt-12 border-t border-white/5">
                        <div>
                            <div class="text-3xl lg:text-4xl font-bold text-white mb-1">50+</div>
                            <div class="text-xs tracking-[0.2em] text-white/30">PROJECTS</div>
                        </div>
                        <div>
                            <div class="text-3xl lg:text-4xl font-bold text-white mb-1">30+</div>
                            <div class="text-xs tracking-[0.2em] text-white/30">CLIENTS</div>
                        </div>
                        <div>
                            <div class="text-3xl lg:text-4xl font-bold text-white mb-1">15+</div>
                            <div class="text-xs tracking-[0.2em] text-white/30">TECHNOLOGIES</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Skills Section --}}
    @if(isset($skills) && !$skills->isEmpty())
        @include('components.sections.skills-section', [
            'skills' => $skills,
            'title' => 'TECHNICAL SKILLS',
            'layout' => 'grid',
        ])
    @endif

    {{-- CTA Section --}}
    <section class="py-20 lg:py-28 px-6 lg:px-16 bg-black text-center border-t border-white/5">
        <div class="max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold tracking-[0.05em] mb-6">
                LET'S WORK TOGETHER
            </h2>
            <p class="text-white/40 text-lg mb-10">
                I'm always open to new opportunities and interesting projects. 
                Feel free to reach out if you'd like to collaborate!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.index') }}" 
                   class="inline-flex items-center justify-center px-10 py-4 border border-white/30 text-white text-sm tracking-[0.2em] font-medium hover:bg-white hover:text-black transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    GET IN TOUCH
                </a>
                <a href="{{ route('download.resume') }}" 
                   class="inline-flex items-center justify-center px-10 py-4 border border-white/10 text-white/60 text-sm tracking-[0.2em] font-medium hover:border-white/30 hover:text-white transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    DOWNLOAD RESUME
                </a>
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