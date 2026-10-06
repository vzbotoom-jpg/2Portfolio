{{-- resources/views/components/sections/testimonials-section.blade.php --}}
@props([
    'testimonials' => [],
    'title' => 'WHAT CLIENTS SAY',
    'subtitle' => null,
])

@php
    $defaultTestimonials = [
        [
            'name' => 'John Doe',
            'position' => 'CEO, TechCorp',
            'company' => 'TechCorp Inc.',
            'avatar' => null,
            'content' => 'Working with this developer was an absolute pleasure. The attention to detail and technical expertise delivered a product that exceeded our expectations. Highly recommended for any web development project.',
            'rating' => 5,
            'project_name' => 'E-Commerce Platform',
        ],
        [
            'name' => 'Jane Smith',
            'position' => 'CTO, StartupX',
            'company' => 'StartupX',
            'avatar' => null,
            'content' => 'Exceptional developer with a great eye for design and user experience. Delivered our project on time and within budget. The communication throughout the development process was outstanding.',
            'rating' => 5,
            'project_name' => 'Mobile Banking App',
        ],
        [
            'name' => 'Mike Johnson',
            'position' => 'Founder, DigitalPro',
            'company' => 'DigitalPro',
            'avatar' => null,
            'content' => 'Incredible technical skills combined with creative problem-solving abilities. Transformed our vision into a stunning, high-performance application that our users love.',
            'rating' => 5,
            'project_name' => 'AI Analytics Dashboard',
        ],
        [
            'name' => 'Sarah Williams',
            'position' => 'Product Manager, InnovateLabs',
            'company' => 'InnovateLabs',
            'avatar' => null,
            'content' => 'One of the best developers I\'ve worked with. Deep understanding of modern web technologies and always goes the extra mile to ensure project success.',
            'rating' => 5,
            'project_name' => 'Healthcare Platform',
        ],
    ];
    
    $testimonials = !empty($testimonials) ? $testimonials : $defaultTestimonials;
@endphp

<section class="py-24 lg:py-32 px-6 lg:px-16 bg-black relative overflow-hidden">
    
    {{-- Background Decoration --}}
    <div class="absolute inset-0 opacity-[0.02]">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 50% 50%, #fff 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>
    
    <div class="max-w-[1400px] mx-auto relative z-10">
        
        {{-- Section Header --}}
        <div class="text-center mb-16 lg:mb-20" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-4">
                {{ $title }}
            </h2>
            <div class="w-24 h-px bg-white/20 mx-auto mb-6"></div>
            @if($subtitle)
                <p class="text-white/40 text-lg max-w-2xl mx-auto">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
        
        {{-- Testimonials Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($testimonials as $index => $testimonial)
                @php $testimonial = (object) $testimonial; @endphp
                
                <div class="group relative p-8 lg:p-10 border border-white/5 hover:border-white/10 transition-all duration-500 bg-gradient-to-b from-white/[0.02] to-transparent"
                     data-aos="fade-up"
                     data-aos-delay="{{ $index * 100 }}">
                    
                    {{-- Quote Icon --}}
                    <div class="mb-6">
                        <svg class="w-8 h-8 text-white/5 group-hover:text-white/10 transition-colors duration-500" 
                             fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                    
                    {{-- Content --}}
                    <blockquote class="text-white/60 text-base leading-relaxed mb-8 group-hover:text-white/80 transition-colors duration-300">
                        "{{ $testimonial->content }}"
                    </blockquote>
                    
                    {{-- Rating Stars --}}
                    <div class="flex items-center space-x-1 mb-6">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= ($testimonial->rating ?? 5) ? 'text-yellow-400' : 'text-gray-700' }}" 
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    
                    {{-- Author Info --}}
                    <div class="flex items-center space-x-4 border-t border-white/5 pt-6">
                        {{-- Avatar --}}
                        <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center flex-shrink-0 border border-white/5">
                            @if(isset($testimonial->avatar) && $testimonial->avatar)
                                <img src="{{ $testimonial->avatar }}" 
                                     alt="{{ $testimonial->name }}" 
                                     class="w-full h-full rounded-full object-cover">
                            @else
                                <span class="text-lg font-bold text-white/30">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-white/80">
                                {{ $testimonial->name }}
                            </div>
                            <div class="text-xs text-white/30 mt-0.5">
                                {{ $testimonial->position }}
                                @if(isset($testimonial->company))
                                    , {{ $testimonial->company }}
                                @endif
                            </div>
                        </div>
                        
                        {{-- Project Link (Optional) --}}
                        @if(isset($testimonial->project_name))
                            <div class="ml-auto">
                                <span class="text-xs px-3 py-1 border border-white/5 rounded-full text-white/20">
                                    {{ $testimonial->project_name }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- Stats Banner --}}
        <div class="mt-16 lg:mt-20 p-8 lg:p-12 border border-white/5 bg-white/[0.01] text-center"
             data-aos="fade-up">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="text-4xl lg:text-5xl font-bold mb-2">92%</div>
                    <div class="text-xs tracking-[0.3em] text-white/30">CLIENT SATISFACTION</div>
                </div>
                <div>
                    <div class="text-4xl lg:text-5xl font-bold mb-2">19+</div>
                    <div class="text-xs tracking-[0.3em] text-white/30">PROJECTS DELIVERED</div>
                </div>
                <div>
                    <div class="text-4xl lg:text-5xl font-bold mb-2">4,5★</div>
                    <div class="text-xs tracking-[0.3em] text-white/30">AVERAGE RATING</div>
                </div>
            </div>
        </div>
    </div>
</section>