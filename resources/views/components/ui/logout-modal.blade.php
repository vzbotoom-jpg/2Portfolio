{{-- resources/views/components/ui/logout-modal.blade.php --}}
<div x-data="{ open: false }"
     data-logout-modal
     x-on:open-logout-modal.window="open = true"
     x-on:close-logout-modal.window="open = false"
     x-on:keydown.escape.window="open = false"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     style="display: none;">
    
    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-black/80 backdrop-blur-sm"
         @click="open = false">
    </div>
    
    {{-- Modal Card --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-lg bg-[#0d0d0d] border border-white/10 rounded-2xl shadow-2xl overflow-hidden"
         @click.outside="open = false">
        
        {{-- Modal Content --}}
        <div class="p-10">
            {{-- Title --}}
            <h3 class="text-2xl sm:text-3xl font-bold text-white text-center mb-8 leading-tight tracking-tight">
                Are you sure you want<br>to log out?
            </h3>
            
            {{-- User Info Card --}}
            <div class="flex items-center gap-4 p-5 bg-[#111111] border border-white/10 rounded-xl mb-8">
                {{-- Avatar --}}
                <div class="w-14 h-14 rounded-full bg-[#1a1a1a] border border-white/5 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                
                {{-- User Details --}}
                <div class="flex-1 min-w-0">
                    <div class="text-base font-semibold text-white truncate">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>
                    <div class="text-sm text-white/40 truncate mt-0.5">
                        {{ auth()->user()->email ?? '' }}
                    </div>
                </div>
            </div>
            
            {{-- Action Buttons (Stacked) --}}
            <div class="flex flex-col gap-3">
                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full px-6 py-4 bg-white text-black font-semibold rounded-full hover:bg-white/90 transition-all duration-300 flex items-center justify-center gap-2 text-sm tracking-[0.15em]">
                        <span>LOGOUT</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>
                
                {{-- Cancel Button --}}
                <button @click="open = false"
                        class="w-full px-6 py-4 bg-transparent text-white font-semibold rounded-full border border-white/15 hover:bg-white/5 hover:border-white/25 transition-all duration-300 text-sm tracking-[0.15em]">
                    CANCEL
                </button>
            </div>
        </div>
    </div>
</div>