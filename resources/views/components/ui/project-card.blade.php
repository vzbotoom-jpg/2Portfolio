{{-- resources/views/components/ui/project-card.blade.php --}}
@props([
    'project' => null,
    'variant' => 'default', // default, minimal, bordered, gradient
    'showCategory' => true,
    'showExcerpt' => false,
    'showTechnologies' => false,
    'aspectRatio' => '4/5',
    'overlayOpacity' => 0.4,
    'animated' => true,
])

@php
    // Initialize default values
    $title = 'Project Title';
    $slug = null;
    $category = 'PROJECT';
    $description = '';
    $image = asset('images/projects/placeholder.webp');
    $thumbnail = asset('images/projects/placeholder.webp');
    $technologies = [];
    $url = '#';
    $client = null;
    $duration = null;

    // If project data is provided, extract values
    if ($project) {
        // Convert to object if array
        if (is_array($project)) {
            $project = (object) $project;
        }
        
        $title = $project->title ?? 'Project Title';
        $slug = $project->slug ?? null;
        $category = $project->category ?? 'PROJECT';
        $description = $project->description ?? $project->short_description ?? '';
        $technologies = $project->technologies ?? [];
        $client = $project->client ?? null;
        $duration = $project->duration ?? null;
        
        // Handle image URLs
        if (isset($project->image_url)) {
            $image = $project->image_url;
        } elseif (isset($project->image)) {
            $image = Str::startsWith($project->image, 'http') 
                ? $project->image 
                : asset('storage/' . $project->image);
        }
        
        if (isset($project->thumbnail_url)) {
            $thumbnail = $project->thumbnail_url;
        } elseif (isset($project->thumbnail)) {
            if (Str::startsWith($project->thumbnail, 'http')) {
                $thumbnail = $project->thumbnail;
            } elseif (file_exists(public_path(ltrim($project->thumbnail, '/')))) {
                $thumbnail = asset(ltrim($project->thumbnail, '/'));
            } elseif (file_exists(public_path('storage/' . ltrim($project->thumbnail, '/')))) {
                $thumbnail = asset('storage/' . ltrim($project->thumbnail, '/'));
            } else {
                $thumbnail = $image;
            }
        } else {
            $thumbnail = $image;
        }
        
        // Generate URL based on slug
        if ($slug && $slug !== '#') {
            // Gunakan route projects.show karena sudah sesuai dengan web.php
            $url = route('projects.show', ['slug' => $slug]);
        } else {
            $url = '#';
        }
    }
    
    // Determine aspect ratio class
    $aspectClasses = match($aspectRatio) {
        '1/1' => 'aspect-square',
        '16/9' => 'aspect-video',
        '3/4' => 'aspect-[3/4]',
        '4/3' => 'aspect-[4/3]',
        '3/2' => 'aspect-[3/2]',
        '2/3' => 'aspect-[2/3]',
        default => 'aspect-[4/5]',
    };
    
    // Determine card variant classes
    $cardClasses = match($variant) {
        'minimal' => 'bg-gray-900',
        'bordered' => 'bg-gray-900 border border-white/10',
        'gradient' => 'bg-gradient-to-b from-gray-900 to-black',
        'glass' => 'bg-black/50 backdrop-blur-sm border border-white/5',
        default => 'bg-gray-900',
    };
    
    // Data attributes for animations
    $dataAttributes = '';
    if ($animated) {
        $dataAttributes = 'data-aos="fade-up" data-aos-duration="800"';
    }
@endphp

@if($url && $url !== '#')
    <a href="{{ $url }}" 
       class="group relative overflow-hidden {{ $aspectClasses }} {{ $cardClasses }} cursor-pointer block glow-card"
       {!! $dataAttributes !!}
       title="{{ $title }}">
@else
    <div class="group relative overflow-hidden {{ $aspectClasses }} {{ $cardClasses }} glow-card"
         {!! $dataAttributes !!}>
@endif
    
    {{-- Project Image --}}
    <div class="absolute inset-0 z-10">
        <img src="{{ $thumbnail }}" 
             alt="{{ $title }}" 
             loading="lazy"
             class="w-full h-full object-cover transition-all duration-700 ease-out-expo group-hover:scale-110 group-hover:opacity-50"
             onerror="this.onerror=null; this.src='{{ asset('images/projects/placeholder.webp') }}';">
    </div>
    
    {{-- Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent z-20 
                opacity-60 group-hover:opacity-80 transition-opacity duration-500">
    </div>
    
    {{-- Hover Border Effect --}}
    <div class="absolute inset-3 border border-white/0 group-hover:border-white/20 z-20 transition-all duration-500 pointer-events-none">
    </div>
    
    {{-- Content --}}
    <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-6 lg:p-8 z-30 transform translate-y-2 group-hover:translate-y-0 transition-all duration-500">
        
        {{-- Category Badge --}}
        @if($showCategory && $category)
            <span class="inline-block text-[10px] sm:text-xs tracking-[0.3em] text-white/50 mb-2 uppercase">
                {{ $category }}
            </span>
        @endif
        
        {{-- Title --}}
        <h3 class="text-lg sm:text-xl lg:text-2xl font-bold tracking-wider mb-2 text-white group-hover:text-white transition-colors duration-300 line-clamp-2">
            {{ $title }}
        </h3>
        
        {{-- Description / Excerpt --}}
        @if($showExcerpt && $description)
            <p class="text-sm text-white/50 line-clamp-2 mb-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-2 group-hover:translate-y-0">
                {{ Str::limit(strip_tags($description), 100) }}
            </p>
        @endif
        
        {{-- Technologies --}}
        @if($showTechnologies && !empty($technologies))
            <div class="flex flex-wrap gap-1.5 mt-3 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-2 group-hover:translate-y-0">
                @foreach(array_slice((array)$technologies, 0, 4) as $tech)
                    <span class="text-[10px] sm:text-xs px-2 py-1 border border-white/10 rounded-full text-white/40">
                        {{ $tech }}
                    </span>
                @endforeach
                @if(count((array)$technologies) > 4)
                    <span class="text-[10px] sm:text-xs px-2 py-1 border border-white/10 rounded-full text-white/40">
                        +{{ count((array)$technologies) - 4 }}
                    </span>
                @endif
            </div>
        @endif
        
        {{-- View Project Indicator --}}
        <div class="flex items-center space-x-2 mt-3 sm:mt-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-2 group-hover:translate-y-0">
            <span class="text-[10px] sm:text-xs tracking-[0.2em] text-white/60 font-medium">VIEW PROJECT</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white/60 group-hover:translate-x-1 transition-transform duration-300" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </div>
    </div>
    
    {{-- Featured Badge (Optional) --}}
    @if(isset($project->featured) && $project->featured)
        <div class="absolute top-3 right-3 z-30">
            <span class="inline-flex items-center px-2 py-1 bg-white/10 backdrop-blur-sm border border-white/10 rounded text-[10px] tracking-[0.2em] text-white/80">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                FEATURED
            </span>
        </div>
    @endif

@if($url && $url !== '#')
    </a>
@else
    </div>
@endif