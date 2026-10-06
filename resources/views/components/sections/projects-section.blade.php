{{-- resources/views/components/sections/projects-section.blade.php --}}
@props([
    'projects' => [],
    'title' => 'FEATURED PROJECTS',
    'subtitle' => null,
    'showViewAll' => true,
    'viewAllUrl' => null,
    'columns' => 3,
    'variant' => 'default',
])

@php
    $viewAllUrl = $viewAllUrl ?? route('projects.index');
    $gridCols = match($columns) {
        2 => 'md:grid-cols-2',
        4 => 'md:grid-cols-2 lg:grid-cols-4',
        default => 'md:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section class="py-24 lg:py-32 px-6 lg:px-16 bg-black">
    <div class="max-w-[1400px] mx-auto">
        
        {{-- Section Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 lg:mb-20">
            <div data-aos="fade-right">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-4">
                    {{ $title }}
                </h2>
                <div class="w-24 h-px bg-white/20"></div>
                @if($subtitle)
                    <p class="mt-6 text-white/40 text-base max-w-xl">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            
            @if($showViewAll)
                <div class="mt-8 lg:mt-0" data-aos="fade-left">
                    <x-ui.button 
                        :href="$viewAllUrl" 
                        variant="outline" 
                        size="md"
                        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>'
                        icon-position="right">
                        VIEW ALL PROJECTS
                    </x-ui.button>
                </div>
            @endif
        </div>
        
        {{-- Projects Grid --}}
        <div class="grid grid-cols-1 {{ $gridCols }} gap-6 lg:gap-8">
            @forelse($projects as $index => $project)
                <x-ui.project-card 
                    :project="$project" 
                    :variant="$variant"
                    :show-category="true"
                    :animated="true"
                    :data-aos="'fade-up'"
                    :data-aos-delay="$index * 150"
                />
            @empty
                {{-- Placeholder Projects --}}
                @for($i = 1; $i <= 3; $i++)
                    <x-ui.project-card 
                        :project="null"
                        :variant="$variant"
                    />
                @endfor
            @endforelse
        </div>
        
        {{-- Bottom CTA (Mobile) --}}
        @if($showViewAll)
            <div class="mt-12 text-center lg:hidden">
                <x-ui.button 
                    :href="$viewAllUrl" 
                    variant="outline" 
                    size="lg"
                    full-width="true">
                    VIEW ALL PROJECTS
                </x-ui.button>
            </div>
        @endif
    </div>
</section>