{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') | Portfolio CMS</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/css/admin.css'])
    
    @stack('styles')
</head>
<body class="bg-gray-950 text-gray-100 font-sans antialiased">
    
    {{-- Admin Sidebar --}}
    <aside x-data="{ sidebarOpen: true }" 
           :class="{ '-translate-x-full lg:translate-x-0 lg:w-20': !sidebarOpen, 'translate-x-0 w-64': sidebarOpen }"
           class="fixed top-0 left-0 h-full bg-gray-900 border-r border-white/5 z-40 transition-all duration-300 overflow-hidden">
        
        {{-- Sidebar Header --}}
        <div class="flex items-center justify-between h-16 px-4 border-b border-white/5">
            <a href="{{ route('admin.dashboard') }}" 
               :class="{ 'opacity-0 lg:hidden': !sidebarOpen }"
               class="text-white font-bold text-lg tracking-[0.2em] transition-opacity duration-300">
                CMS
            </a>
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="text-white/60 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        
        {{-- Sidebar Navigation --}}
        <nav class="mt-6 px-2 space-y-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white/5 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span :class="{ 'hidden': !sidebarOpen }">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.projects.index') }}" 
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white/5 {{ request()->routeIs('admin.projects.*') ? 'bg-white/10 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span :class="{ 'hidden': !sidebarOpen }">Projects</span>
            </a>
            
            <a href="{{ route('admin.skills.index') }}" 
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white/5 {{ request()->routeIs('admin.skills.*') ? 'bg-white/10 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span :class="{ 'hidden': !sidebarOpen }">Skills</span>
            </a>
            
            <a href="{{ route('admin.services.index') }}" 
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white/5 {{ request()->routeIs('admin.services.*') ? 'bg-white/10 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span :class="{ 'hidden': !sidebarOpen }">Services</span>
            </a>
            
            <a href="{{ route('admin.testimonials.index') }}" 
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white/5 {{ request()->routeIs('admin.testimonials.*') ? 'bg-white/10 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <span :class="{ 'hidden': !sidebarOpen }">Testimonials</span>
            </a>
            
            <a href="{{ route('admin.messages.index') }}" 
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white/5 {{ request()->routeIs('admin.messages.*') ? 'bg-white/10 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span :class="{ 'hidden': !sidebarOpen }">Messages</span>
            </a>
            
            <a href="{{ route('admin.settings') }}" 
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white/5 {{ request()->routeIs('admin.settings') ? 'bg-white/10 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span :class="{ 'hidden': !sidebarOpen }">Settings</span>
            </a>
        </nav>
        
        {{-- Sidebar Footer --}}
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center w-full px-3 py-3 text-sm font-medium text-gray-400 rounded-lg transition-all duration-200 hover:bg-white/5 hover:text-white">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span :class="{ 'hidden': !sidebarOpen }">Logout</span>
                </button>
            </form>
        </div>
    </aside>
    
    {{-- Main Content Area --}}
    <div :class="{ 'lg:ml-64': sidebarOpen, 'lg:ml-20': !sidebarOpen }" 
         class="transition-all duration-300 min-h-screen">
        
        {{-- Top Navigation --}}
        <header class="sticky top-0 z-30 bg-gray-950/80 backdrop-blur-md border-b border-white/5">
            <div class="flex items-center justify-between h-16 px-6">
                {{-- Mobile Menu Toggle --}}
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="lg:hidden text-white/60 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                
                {{-- Breadcrumb / Page Title --}}
                <div class="flex items-center space-x-4">
                    <h1 class="text-lg font-semibold tracking-wide">@yield('page_title', 'Dashboard')</h1>
                </div>
                
                {{-- User Menu --}}
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" 
                       target="_blank"
                       class="text-sm text-gray-400 hover:text-white transition-colors">
                        View Site
                    </a>
                    
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-sm font-medium">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>
        
        {{-- Page Content --}}
        <div class="p-6 lg:p-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-emerald-400 text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-red-400 text-sm">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
            
            @if ($errors->any())
                <div x-data="{ show: true }" 
                     x-show="show"
                     class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-red-400 text-sm font-medium mb-2">Please fix the following errors:</h3>
                            <ul class="list-disc list-inside text-red-300 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            {{-- Main Content --}}
            @yield('content')
        </div>
    </div>
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/js/app.js', 'resources/js/admin.js'])
    
    @stack('scripts')
</body>
</html>