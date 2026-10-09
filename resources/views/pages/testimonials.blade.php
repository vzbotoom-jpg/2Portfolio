{{-- resources/views/pages/testimonials.blade.php --}}
@extends('layouts.app')
@section('title', 'Testimonials')
@section('meta_description', 'Read what clients say about working with me. Real testimonials from real projects.')
@push('head')
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
@endpush
@section('content')
{{-- Hero Section --}}
<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 px-6 lg:px-16 bg-black overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/[0.01] rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
    <div class="max-w-[1400px] mx-auto relative z-10 text-center" data-aos="fade-up">
        <span class="text-xs tracking-[0.3em] text-white/30 mb-4 block">TESTIMONIALS</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6 leading-[1.1]">
            WHAT CLIENTS SAY
        </h1>
        <div class="w-24 h-px bg-white/20 mx-auto mb-8"></div>
        <p class="text-white/40 text-lg max-w-2xl mx-auto leading-relaxed">
            Don't just take my word for it — hear from some of the amazing clients 
            I've had the pleasure of working with.
        </p>
    </div>
</section>

{{-- Testimonials Grid --}}
<section class="py-16 lg:py-24 px-6 lg:px-16 bg-black">
    <div class="max-w-[1400px] mx-auto">
        @if($testimonials->count() > 0)
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
                                    <img src="{{ asset('storage/' . $testimonial->avatar) }}" 
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
        @else
            {{-- Empty State --}}
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-white/10 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="text-xl font-bold tracking-wider mb-4">No Testimonials Yet</h3>
                <p class="text-white/40 mb-8">Check back soon for client reviews.</p>
            </div>
        @endif
    </div>
</section>

{{-- Stats Banner --}}
<section class="py-16 lg:py-20 px-6 lg:px-16 bg-black border-t border-white/5">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center" data-aos="fade-up">
            <div>
                <div class="text-4xl lg:text-5xl font-bold mb-2 bg-gradient-to-b from-white to-white/50 bg-clip-text text-transparent">
                    92%
                </div>
                <div class="text-xs tracking-[0.3em] text-white/30">CLIENT SATISFACTION</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-bold mb-2 bg-gradient-to-b from-white to-white/50 bg-clip-text text-transparent">
                    30+
                </div>
                <div class="text-xs tracking-[0.3em] text-white/30">PROJECTS DELIVERED</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-bold mb-2 bg-gradient-to-b from-white to-white/50 bg-clip-text text-transparent">
                    4.9★
                </div>
                <div class="text-xs tracking-[0.3em] text-white/30">AVERAGE RATING</div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 lg:py-28 px-6 lg:px-16 bg-gradient-to-b from-black to-gray-950 text-center border-t border-white/5">
    <div class="max-w-3xl mx-auto" data-aos="fade-up">
        <h2 class="text-3xl lg:text-4xl font-bold tracking-[0.05em] mb-6">
            READY TO BECOME THE NEXT SUCCESS STORY?
        </h2>
        <p class="text-white/40 text-lg mb-10">
            Let's work together to bring your ideas to life. Get in touch and let's discuss your project.
        </p>
        <a href="{{ route('contact.index') }}" 
           class="relative inline-flex items-center justify-center px-10 py-4 text-sm tracking-[0.2em] font-medium text-white border border-white/30 overflow-hidden group transition-all duration-500 hover:border-white">
            <span class="relative z-10 transition-colors duration-500 group-hover:text-black">START A PROJECT</span>
            <div class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out"></div>
            <svg class="relative z-10 w-4 h-4 ml-2 transform transition-all duration-500 group-hover:translate-x-1 group-hover:text-black" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: true,
    offset: 50
});
</script>
@endpush