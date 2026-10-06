{{-- resources/views/components/ui/button.blade.php --}}
@props([
    'variant' => 'outline', // outline, filled, ghost, text
    'size' => 'md', // sm, md, lg, xl
    'href' => null,
    'type' => 'button',
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'right', // left, right
    'fullWidth' => false,
    'animated' => true,
    'glow' => false,
    'target' => null,
    'rel' => null,
])

@php
    $baseClasses = 'relative inline-flex items-center justify-center font-medium tracking-[0.2em] uppercase transition-all duration-500 focus:outline-none focus:ring-2 focus:ring-white/20 focus:ring-offset-2 focus:ring-offset-black disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = match($variant) {
        'filled' => 'bg-white text-black border border-white hover:bg-transparent hover:text-white',
        'ghost' => 'bg-transparent text-white/70 hover:text-white hover:bg-white/5',
        'text' => 'bg-transparent text-white/70 hover:text-white p-0 border-none',
        default => 'bg-transparent text-white border border-white/30 hover:border-white hover:bg-white hover:text-black',
    };
    
    $sizeClasses = match($size) {
        'sm' => 'px-6 py-2.5 text-xs',
        'lg' => 'px-10 py-4 text-sm',
        'xl' => 'px-12 py-5 text-base',
        default => 'px-8 py-3.5 text-sm',
    };
    
    $widthClass = $fullWidth ? 'w-full' : '';
    
    $classes = "{$baseClasses} {$variantClasses} {$sizeClasses} {$widthClass}";
    
    if ($animated && $variant === 'outline') {
        $classes .= ' overflow-hidden group';
    }
    
    if ($glow) {
        $classes .= ' glow-button';
    }
@endphp

@if($href)
    <a href="{{ $href }}" 
       {{ $attributes->merge(['class' => $classes]) }}
       @if($target) target="{{ $target }}" @endif
       @if($rel) rel="{{ $rel }}" @endif>
        @if($icon && $iconPosition === 'left')
            <span class="relative z-10 mr-2 transition-transform duration-500 group-hover:-translate-x-1">
                {!! $icon !!}
            </span>
        @endif
        
        <span class="relative z-10">
            {{ $slot }}
        </span>
        
        @if($icon && $iconPosition === 'right')
            <span class="relative z-10 ml-2 transition-transform duration-500 group-hover:translate-x-1">
                {!! $icon !!}
            </span>
        @endif
        
        @if($animated && $variant === 'outline')
            <span class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out"></span>
        @endif
    </a>
@else
    <button type="{{ $type }}" 
            {{ $attributes->merge(['class' => $classes]) }}
            @disabled($disabled)>
        @if($icon && $iconPosition === 'left')
            <span class="relative z-10 mr-2 transition-transform duration-500 group-hover:-translate-x-1">
                {!! $icon !!}
            </span>
        @endif
        
        <span class="relative z-10">
            {{ $slot }}
        </span>
        
        @if($icon && $iconPosition === 'right')
            <span class="relative z-10 ml-2 transition-transform duration-500 group-hover:translate-x-1">
                {!! $icon !!}
            </span>
        @endif
        
        @if($animated && $variant === 'outline')
            <span class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out"></span>
        @endif
    </button>
@endif