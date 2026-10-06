{{-- resources/views/pages/errors/404.blade.php --}}
@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
    <section class="relative min-h-screen flex items-center justify-center px-6 lg:px-16 bg-black overflow-hidden">
        
        {{-- Background Decoration --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px]">
                <div class="absolute inset-0 border border-white/[0.02] rounded-full animate-pulse"></div>
                <div class="absolute inset-16 border border-white/[0.01] rounded-full"></div>
                <div class="absolute inset-32 border border-white/[0.005] rounded-full"></div>
            </div>
        </div>
        
        {{-- Grid Pattern --}}
        <div class="absolute inset-0 opacity-[0.02]">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
        
        {{-- Content --}}
        <div class="relative z-10 text-center max-w-2xl mx-auto">
            {{-- 404 Number --}}
            <div class="relative mb-8">
                <h1 class="text-[150px] sm:text-[200px] lg:text-[250px] font-bold leading-none tracking-tighter text-white/[0.02] select-none">
                    404
                </h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h1 class="text-[100px] sm:text-[140px] lg:text-[180px] font-bold leading-none tracking-tighter bg-gradient-to-b from-white to-white/20 bg-clip-text text-transparent">
                        404
                    </h1>
                </div>
            </div>
            
            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-[0.1em] mb-4">
                PAGE NOT FOUND
            </h2>
            
            {{-- Divider --}}
            <div class="w-16 h-px bg-white/20 mx-auto mb-6"></div>
            
            {{-- Description --}}
            <p class="text-white/40 text-base lg:text-lg mb-12 leading-relaxed">
                The page you're looking for doesn't exist or has been moved. 
                Let's get you back on track.
            </p>
            
            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center px-10 py-4 border border-white/30 text-white text-sm tracking-[0.2em] font-medium hover:bg-white hover:text-black transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    BACK TO HOME
                </a>
                <a href="{{ route('contact.index') }}" 
                   class="inline-flex items-center justify-center px-10 py-4 border border-white/10 text-white/60 text-sm tracking-[0.2em] font-medium hover:border-white/30 hover:text-white transition-all duration-300">
                    CONTACT ME
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
            
            {{-- Search Suggestion (Optional) --}}
            <div class="mt-16">
                <p class="text-xs text-white/20 tracking-wider mb-4">SEARCH FOR PROJECTS</p>
                <form action="{{ route('projects.index') }}" method="GET" class="flex max-w-md mx-auto">
                    <input type="text" 
                           name="search" 
                           placeholder="Search projects..." 
                           class="flex-1 bg-white/5 border border-white/10 px-4 py-3 text-sm text-white placeholder-white/20 focus:outline-none focus:border-white/30 transition-colors">
                    <button type="submit" 
                            class="px-6 border border-l-0 border-white/10 text-white/60 hover:text-white hover:bg-white/5 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        
        {{-- Corner Decorations --}}
        <div class="absolute top-8 left-8 w-16 h-16 border-l border-t border-white/5 hidden lg:block"></div>
        <div class="absolute top-8 right-8 w-16 h-16 border-r border-t border-white/5 hidden lg:block"></div>
        <div class="absolute bottom-8 left-8 w-16 h-16 border-l border-b border-white/5 hidden lg:block"></div>
        <div class="absolute bottom-8 right-8 w-16 h-16 border-r border-b border-white/5 hidden lg:block"></div>
    </section>
    
    {{-- Related Links Section --}}
    <section class="py-16 lg:py-20 px-6 lg:px-16 bg-black border-t border-white/5">
        <div class="max-w-[1400px] mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-lg tracking-[0.2em] text-white/30">QUICK LINKS</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <a href="{{ route('home') }}" 
                   class="group p-6 border border-white/5 hover:border-white/20 transition-all duration-300 text-center bg-white/[0.01]">
                    <svg class="w-8 h-8 text-white/20 group-hover:text-white/60 mx-auto mb-4 transition-colors duration-300" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-sm tracking-wider text-white/50 group-hover:text-white transition-colors duration-300">Home</span>
                </a>
                
                <a href="{{ route('projects.index') }}" 
                   class="group p-6 border border-white/5 hover:border-white/20 transition-all duration-300 text-center bg-white/[0.01]">
                    <svg class="w-8 h-8 text-white/20 group-hover:text-white/60 mx-auto mb-4 transition-colors duration-300" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-sm tracking-wider text-white/50 group-hover:text-white transition-colors duration-300">Projects</span>
                </a>
                
                <a href="{{ route('about') }}" 
                   class="group p-6 border border-white/5 hover:border-white/20 transition-all duration-300 text-center bg-white/[0.01]">
                    <svg class="w-8 h-8 text-white/20 group-hover:text-white/60 mx-auto mb-4 transition-colors duration-300" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm tracking-wider text-white/50 group-hover:text-white transition-colors duration-300">About</span>
                </a>
                
                <a href="{{ route('contact.index') }}" 
                   class="group p-6 border border-white/5 hover:border-white/20 transition-all duration-300 text-center bg-white/[0.01]">
                    <svg class="w-8 h-8 text-white/20 group-hover:text-white/60 mx-auto mb-4 transition-colors duration-300" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm tracking-wider text-white/50 group-hover:text-white transition-colors duration-300">Contact</span>
                </a>
            </div>
        </div>
    </section>
@endsection