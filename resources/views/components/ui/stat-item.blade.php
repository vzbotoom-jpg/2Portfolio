{{-- resources/views/components/ui/stat-item.blade.php --}}
@props([
    'number' => '0',
    'label' => 'STAT',
    'icon' => null,
    'description' => null,
    'prefix' => '',
    'suffix' => '+',
    'animated' => true,
    'duration' => 2000,
])

@php
    $numericValue = (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT);
@endphp

<div class="text-center group"
     @if($animated)
     x-data="{ 
        count: 0,
        target: {{ $numericValue }},
        prefix: '{{ $prefix }}',
        suffix: '{{ $suffix }}',
        animated: false
     }"
     x-intersect:enter="
        animated = true;
        let start = 0;
        const duration = {{ $duration }};
        const step = target / (duration / 16);
        const interval = setInterval(() => {
            start += step;
            if (start >= target) {
                count = target;
                clearInterval(interval);
            } else {
                count = Math.floor(start);
            }
        }, 16);
     "
     @endif>
    
    {{-- Icon --}}
    @if($icon)
        <div class="mb-4 text-white/20 group-hover:text-white/40 transition-colors duration-500">
            {!! $icon !!}
        </div>
    @endif
    
    {{-- Number --}}
    <div class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold tracking-wider mb-3 tabular-nums bg-gradient-to-b from-white to-white/50 bg-clip-text text-transparent">
        @if($animated)
            <span x-text="prefix + count + suffix"></span>
        @else
            <span>{{ $prefix }}{{ $number }}{{ $suffix }}</span>
        @endif
    </div>
    
    {{-- Label --}}
    <div class="text-xs md:text-sm tracking-[0.3em] text-white/30 group-hover:text-white/50 transition-colors duration-500">
        {{ $label }}
    </div>
    
    {{-- Description --}}
    @if($description)
        <p class="mt-2 text-sm text-white/20 max-w-[200px] mx-auto">
            {{ $description }}
        </p>
    @endif
    
    {{-- Decorative Line --}}
    <div class="mt-4 mx-auto w-8 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent 
                group-hover:via-white/30 transition-all duration-500"></div>
</div>