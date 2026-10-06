{{-- resources/views/components/ui/skill-bar.blade.php --}}
@props([
    'name' => '',
    'level' => 0,
    'category' => null,
    'showPercentage' => true,
    'animated' => true,
    'color' => 'white',
    'duration' => 1000,
    'height' => 'h-px',
    'index' => 0,
])

@php
    $level = max(0, min(100, (int)$level));
    
    $levelCategory = match(true) {
        $level >= 90 => 'Expert',
        $level >= 70 => 'Advanced',
        $level >= 50 => 'Intermediate',
        $level >= 30 => 'Basic',
        default => 'Beginner',
    };
    
    $levelColorClass = match(true) {
        $level >= 90 => 'from-emerald-400 to-emerald-300',
        $level >= 70 => 'from-blue-400 to-blue-300',
        $level >= 50 => 'from-yellow-400 to-yellow-300',
        $level >= 30 => 'from-orange-400 to-orange-300',
        default => 'from-gray-400 to-gray-300',
    };
    
    $animationDelay = $index * 100;
@endphp

<div class="group"
     @if($animated)
     x-data="{ visible: false }"
     x-intersect:enter="visible = true"
     x-intersect:leave="visible = false"
     @endif>
    
    {{-- Skill Header --}}
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center space-x-3">
            <span class="text-sm tracking-[0.2em] text-white/80 group-hover:text-white transition-colors duration-300">
                {{ $name }}
            </span>
            <span class="text-[10px] tracking-[0.3em] text-white/30">
                {{ $levelCategory }}
            </span>
        </div>
        
        @if($showPercentage)
            <span class="text-sm text-white/30 group-hover:text-white/50 transition-colors duration-300 tabular-nums"
                  @if($animated)
                  x-text="visible ? '{{ $level }}%' : '0%'"
                  @else
                  >{{ $level }}%
                  @endif
            </span>
        @endif
    </div>
    
    {{-- Progress Bar --}}
    <div class="relative {{ $height }} bg-white/5 overflow-hidden rounded-full group-hover:bg-white/10 transition-colors duration-300">
        <div class="absolute top-0 left-0 h-full bg-gradient-to-r {{ $levelColorClass }} rounded-full transition-all duration-{{ $duration }} ease-out"
             @if($animated)
             :style="visible ? 'width: {{ $level }}%' : 'width: 0%'"
             style="transition-delay: {{ $animationDelay }}ms"
             @else
             style="width: {{ $level }}%"
             @endif>
            {{-- Shimmer Effect --}}
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
        </div>
    </div>
    
    {{-- Category Badge (Optional) --}}
    @if($category)
        <div class="mt-1">
            <span class="text-[10px] tracking-[0.3em] text-white/20">
                {{ $category }}
            </span>
        </div>
    @endif
</div>

@push('styles')
<style>
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(200%);
        }
    }
    
    .animate-shimmer {
        animation: shimmer 2s infinite;
    }
    
    .transition-duration-1000 {
        transition-duration: 1000ms;
    }
    
    .transition-duration-1500 {
        transition-duration: 1500ms;
    }
    
    .transition-duration-2000 {
        transition-duration: 2000ms;
    }
</style>
@endpush