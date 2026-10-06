{{-- resources/views/pages/errors/500.blade.php --}}
@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
    <section class="relative min-h-screen flex items-center justify-center px-6 lg:px-16 bg-black overflow-hidden">
        
        {{-- Background Decoration --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <div class="w-96 h-96 border border-red-500/10 rounded-full animate-pulse"></div>
                <div class="absolute inset-8 border border-red-500/5 rounded-full"></div>
            </div>
        </div>
        
        {{-- Grid Pattern --}}
        <div class="absolute inset-0 opacity-[0.02]">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
        
        {{-- Content --}}
        <div class="relative z-10 text-center max-w-2xl mx-auto">
            {{-- 500 Number --}}
            <div class="relative mb-8">
                <h1 class="text-[120px] sm:text-[160px] lg:text-[200px] font-bold leading-none tracking-tighter text-white/[0.02] select-none">
                    500
                </h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h1 class="text-[80px] sm:text-[110px] lg:text-[140px] font-bold leading-none tracking-tighter bg-gradient-to-b from-white to-white/20 bg-clip-text text-transparent">
                        500
                    </h1>
                </div>
            </div>
            
            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-[0.1em] mb-4">
                INTERNAL SERVER ERROR
            </h2>
            
            {{-- Divider --}}
            <div class="w-16 h-px bg-white/20 mx-auto mb-6"></div>
            
            {{-- Description --}}
            <p class="text-white/40 text-base lg:text-lg mb-12 leading-relaxed">
                Oops! Something went wrong on our end. Our team has been notified 
                and we're working to fix the issue. Please try again later.
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
                <button onclick="window.location.reload()" 
                        class="inline-flex items-center justify-center px-10 py-4 border border-white/10 text-white/60 text-sm tracking-[0.2em] font-medium hover:border-white/30 hover:text-white transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    TRY AGAIN
                </button>
            </div>
            
            {{-- Contact Info --}}
            <div class="mt-16 pt-12 border-t border-white/5">
                <p class="text-xs text-white/20 tracking-wider mb-4">NEED IMMEDIATE ASSISTANCE?</p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center text-sm">
                    <a href="mailto:hello@yourdomain.com" 
                       class="text-white/40 hover:text-white transition-colors duration-300">
                        hello@yourdomain.com
                    </a>
                    <a href="tel:+1234567890" 
                       class="text-white/40 hover:text-white transition-colors duration-300">
                        +1 234 567 890
                    </a>
                    <a href="{{ route('contact.index') }}" 
                       class="text-white/40 hover:text-white transition-colors duration-300">
                        Contact Form
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Corner Decorations --}}
        <div class="absolute top-8 left-8 w-16 h-16 border-l border-t border-red-500/10 hidden lg:block"></div>
        <div class="absolute top-8 right-8 w-16 h-16 border-r border-t border-red-500/10 hidden lg:block"></div>
        <div class="absolute bottom-8 left-8 w-16 h-16 border-l border-b border-red-500/10 hidden lg:block"></div>
        <div class="absolute bottom-8 right-8 w-16 h-16 border-r border-b border-red-500/10 hidden lg:block"></div>
    </section>
    
    {{-- Status Section --}}
    <section class="py-12 lg:py-16 px-6 lg:px-16 bg-black border-t border-white/5">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 border border-white/5 bg-white/[0.01]">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                    <span class="text-sm text-white/40">Investigating the issue</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xs text-white/20">Error ID: {{ uniqid('ERR-') }}</span>
                    <button onclick="navigator.clipboard.writeText(window.location.href)" 
                            class="text-xs text-white/30 hover:text-white/60 transition-colors">
                        Copy URL
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection