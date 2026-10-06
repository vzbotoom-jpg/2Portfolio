{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-black scroll-smooth">
<head>
    @include('layouts.partials.head')
    
    {{-- Additional Styles --}}
    @stack('styles')
</head>
<body class="bg-black text-white font-sans antialiased selection:bg-white/90 selection:text-black">
    
    {{-- Custom Cursor Glow Effect (disabled — was interfering with text readability) --}}
    {{-- @include('components.ui.cursor-glow') --}}
    
    {{-- Page Loader — hides as soon as the page is actually ready,
         no artificial delay. Falls back instantly if the page was
         already complete by the time Alpine initialized (fast
         connection / cached load). --}}
    <div id="page-loader" 
         class="fixed inset-0 bg-black z-[100] flex items-center justify-center transition-all duration-200"
         x-data="{ loading: true }"
         x-init="
            if (document.readyState === 'complete') {
                loading = false;
            } else {
                window.addEventListener('load', () => { loading = false; }, { once: true });
            }
         "
         x-show="loading"
         x-transition:leave="transition ease-out duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="text-center">
            {{-- Loading Animation --}}
            <div class="relative w-16 h-16 mx-auto mb-8">
                <div class="absolute inset-0 border-2 border-white/10 rounded-full"></div>
                <div class="absolute inset-0 border-2 border-transparent border-t-white rounded-full animate-spin"></div>
                <div class="absolute inset-2 border border-white/5 rounded-full animate-pulse"></div>
            </div>
            <p class="text-xs tracking-[0.5em] text-white/40 font-light animate-pulse">
                LOADING
            </p>
        </div>
    </div>
    
    {{-- Navigation --}}
    @include('layouts.partials.navbar')
    
    {{-- Main Content --}}
    <main class="relative overflow-hidden">
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('layouts.partials.footer')
    
    {{-- Back to Top Button --}}
    <button id="back-to-top" 
            aria-label="Back to top"
            class="fixed bottom-8 right-8 z-50 w-14 h-14 border border-white/20 bg-black/80 backdrop-blur-sm text-white flex items-center justify-center opacity-0 invisible transition-all duration-500 hover:bg-white hover:text-black hover:border-white group cursor-pointer"
            x-data="{ visible: false }"
            x-init="
                window.addEventListener('scroll', () => {
                    visible = window.scrollY > 500;
                });
            "
            :class="{ '!opacity-100 !visible': visible }"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })">
        <svg class="w-5 h-5 transform group-hover:-translate-y-1 transition-transform duration-300" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
    
    {{-- Scripts --}}
    @include('layouts.partials.scripts')
    
    {{-- Additional Scripts --}}
    @stack('scripts')
    
    {{-- Alpine.js Initialization --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>