{{-- resources/views/components/ui/cursor-glow.blade.php --}}
@props([
    'size' => 'w-96 h-96',
    'opacity' => '0.03',
    'blur' => 'blur-3xl',
    'color' => 'bg-white',
    'transitionSpeed' => 'duration-300',
    'showOnMobile' => false,
    'enableParallax' => true,
    'glowVariants' => 1, // Number of glow elements
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
            mouseX: 0,
            mouseY: 0,
            scale: 1,
            isHovering: false,
            isVisible: false,
            lastMove: 0,
            throttleMs: 16, // ~60fps
            
            init() {
                // Track mouse movement with throttling
                document.addEventListener('mousemove', (e) => {
                    const now = Date.now();
                    if (now - this.lastMove >= this.throttleMs) {
                        this.mouseX = e.clientX;
                        this.mouseY = e.clientY;
                        this.isVisible = true;
                        this.lastMove = now;
                    }
                });
                
                // Hide glow when mouse leaves window
                document.addEventListener('mouseleave', () => {
                    this.isVisible = false;
                });
                
                document.addEventListener('mouseenter', () => {
                    this.isVisible = true;
                });
                
                // Detect hover on interactive elements
                this.detectHoverableElements();
                
                // Handle touch devices
                if ('ontouchstart' in window) {
                    this.handleTouch();
                }
                
                // Handle scroll for parallax effect
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
            
            // Get CSS custom properties for other elements to use
            getGlowPosition() {
                return {
                    '--glow-x': this.mouseX + 'px',
                    '--glow-y': this.mouseY + 'px',
                };
            }
        }
    }
</script>

{{-- Additional CSS for glow effects on cards --}}
<style>
    /* Glow effect for cards on hover */
    .glow-card {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .glow-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: radial-gradient(
            800px circle at var(--glow-x, 50%) var(--glow-y, 50%),
            rgba(255, 255, 255, 0.06),
            transparent 40%
        );
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        z-index: 1;
    }
    
    .glow-card:hover::before {
        opacity: 1;
    }
    
    /* Glow effect for buttons */
    .glow-button {
        position: relative;
        overflow: hidden;
    }
    
    .glow-button::after {
        content: '';
        position: absolute;
        inset: -2px;
        background: radial-gradient(
            600px circle at var(--glow-x, 50%) var(--glow-y, 50%),
            rgba(255, 255, 255, 0.15),
            transparent 40%
        );
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        z-index: 0;
    }
    
    .glow-button:hover::after {
        opacity: 1;
    }
    
    /* Glow text effect */
    .glow-text {
        transition: text-shadow 0.3s ease;
    }
    
    .glow-text:hover {
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.3),
                     0 0 40px rgba(255, 255, 255, 0.1);
    }
    
    /* Fade out when not visible */
    #cursor-glow-primary,
    #cursor-glow-secondary,
    #cursor-glow-tertiary {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    
    #cursor-glow-primary[style*="left"],
    #cursor-glow-secondary[style*="left"],
    #cursor-glow-tertiary[style*="left"] {
        opacity: 1;
    }
</style>