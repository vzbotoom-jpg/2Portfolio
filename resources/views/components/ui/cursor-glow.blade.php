{{-- resources/views/components/ui/cursor-glow.blade.php --}}
@props([
    'size' => 'w-96 h-96',
    'opacity' => '0.03',
    'blur' => 'blur-3xl',
    'color' => 'bg-white',
    'transitionSpeed' => 'duration-300',
    'showOnMobile' => false,
    'enableParallax' => true,
    'gradientFrom' => 'from-white',
    'gradientTo' => 'to-transparent',
])

@php
    $mobileClass = $showOnMobile ? 'block' : 'hidden md:block';
@endphp

<div x-data="cursorGlow()" 
     x-init="init()"
     class="fixed inset-0 pointer-events-none z-40 overflow-hidden {{ $mobileClass }}"
     aria-hidden="true">
    
    {{-- Primary Glow --}}
    <div id="cursor-glow-primary"
         class="fixed {{ $size }} rounded-full {{ $color }} opacity-[{{ $opacity }}] {{ $blur }} 
                -translate-x-1/2 -translate-y-1/2 {{ $transitionSpeed }}"
         :style="'left: ' + mouseX + 'px; top: ' + mouseY + 'px;' + 
                 'transform: translate(-50%, -50%) scale(' + scale + ');'">
    </div>
    
    {{-- Secondary Glow (Larger, more diffused) --}}
    <div id="cursor-glow-secondary"
         class="fixed {{ $size }} rounded-full bg-gradient-to-r {{ $gradientFrom }} {{ $gradientTo }} 
                opacity-[0.015] blur-2xl -translate-x-1/2 -translate-y-1/2 transition-all duration-700"
         :style="'left: ' + (mouseX - 50) + 'px; top: ' + (mouseY - 50) + 'px;'">
    </div>
    
    {{-- Tertiary Glow (Smaller, more focused) --}}
    <div id="cursor-glow-tertiary"
         class="fixed w-64 h-64 rounded-full bg-white opacity-[0.02] blur-xl 
                -translate-x-1/2 -translate-y-1/2 transition-all duration-500"
         :style="'left: ' + (mouseX + 30) + 'px; top: ' + (mouseY + 30) + 'px;'">
    </div>
    
    {{-- Interactive Glow (Follows hoverable elements) --}}
    <div id="cursor-glow-interactive"
         class="fixed w-48 h-48 rounded-full bg-white opacity-0 blur-2xl 
                -translate-x-1/2 -translate-y-1/2 transition-all duration-300"
         :class="{ '!opacity-[0.08] !w-56 !h-56': isHovering }"
         :style="'left: ' + mouseX + 'px; top: ' + mouseY + 'px;'">
    </div>
</div>

<script>
    function cursorGlow() {
        return {
            mouseX: -1000,
            mouseY: -1000,
            scale: 1,
            isHovering: false,
            isVisible: false,
            lastMove: 0,
            throttleMs: 16,
            
            init() {
                document.addEventListener('mousemove', (e) => {
                    const now = Date.now();
                    if (now - this.lastMove >= this.throttleMs) {
                        this.mouseX = e.clientX;
                        this.mouseY = e.clientY;
                        this.isVisible = true;
                        this.lastMove = now;
                    }
                });
                
                document.addEventListener('mouseleave', () => {
                    this.isVisible = false;
                });
                
                document.addEventListener('mouseenter', () => {
                    this.isVisible = true;
                });
                
                this.detectHoverableElements();
                
                if ('ontouchstart' in window) {
                    this.handleTouch();
                }
                
                @if($enableParallax)
                    this.handleParallax();
                @endif
            },
            
            detectHoverableElements() {
                const hoverableElements = document.querySelectorAll('a, button, [role="button"], input, textarea, select, .hoverable');
                
                hoverableElements.forEach(el => {
                    el.addEventListener('mouseenter', () => {
                        this.isHovering = true;
                        this.scale = 1.2;
                    });
                    
                    el.addEventListener('mouseleave', () => {
                        this.isHovering = false;
                        this.scale = 1;
                    });
                });
            },
            
            handleTouch() {
                document.addEventListener('touchmove', (e) => {
                    if (e.touches.length > 0) {
                        this.mouseX = e.touches[0].clientX;
                        this.mouseY = e.touches[0].clientY;
                        this.isVisible = true;
                    }
                });
                
                document.addEventListener('touchend', () => {
                    setTimeout(() => {
                        this.isVisible = false;
                    }, 1000);
                });
            },
            
            handleParallax() {
                let lastScrollY = window.scrollY;
                
                window.addEventListener('scroll', () => {
                    const scrollDelta = window.scrollY - lastScrollY;
                    const parallaxStrength = 0.1;
                    this.mouseY += scrollDelta * parallaxStrength;
                    lastScrollY = window.scrollY;
                });
            },
        }
    }
</script>