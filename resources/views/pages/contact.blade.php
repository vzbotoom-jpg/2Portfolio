{{-- resources/views/pages/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact')
@section('meta_description', 'Get in touch with me for project inquiries, collaborations, or just to say hello.')

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-16 lg:pt-40 lg:pb-20 px-6 lg:px-16 bg-black">
        <div class="max-w-[1400px] mx-auto text-center" data-aos="fade-up">
            <span class="text-xs tracking-[0.3em] text-white/30 mb-4 block">CONTACT</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6">
                GET IN TOUCH
            </h1>
            <div class="w-24 h-px bg-white/20 mx-auto mb-6"></div>
            <p class="text-white/40 text-lg max-w-2xl mx-auto">
                Have a project in mind or want to discuss a potential collaboration? 
                I'd love to hear from you.
            </p>
        </div>
    </section>
    
    {{-- Contact Section --}}
    <x-sections.contact-section 
        :contact-info="$contactInfo ?? []"
        title="LET'S CONNECT"
        subtitle="Fill out the form below and I'll get back to you within 24 hours."
    />
    
    {{-- FAQ Section --}}
    <section class="py-24 lg:py-32 px-6 lg:px-16 bg-black border-t border-white/5">
        <div class="max-w-[1400px] mx-auto">
            <div class="text-center mb-16 lg:mb-20" data-aos="fade-up">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-[0.05em] mb-4">
                    FREQUENTLY ASKED QUESTIONS
                </h2>
                <div class="w-24 h-px bg-white/20 mx-auto"></div>
            </div>
            
            <div class="max-w-3xl mx-auto space-y-4">
                @php
                    $faqs = [
                        [
                            'question' => 'What is your typical project timeline?',
                            'answer' => 'Project timelines vary depending on complexity and scope. A simple website might take 2-4 weeks, while a complex web application can take 2-6 months. I always provide detailed timelines during our initial consultation.'
                        ],
                        [
                            'question' => 'What is your development process?',
                            'answer' => 'I follow an agile development methodology: Discovery & Planning → Design & Prototyping → Development → Testing & QA → Deployment → Maintenance & Support. Regular communication and updates are key throughout the process.'
                        ],
                        [
                            'question' => 'Do you offer ongoing maintenance?',
                            'answer' => 'Yes! I offer various maintenance and support packages to ensure your project continues to run smoothly after launch. This includes updates, bug fixes, performance optimization, and security patches.'
                        ],
                        [
                            'question' => 'What technologies do you specialize in?',
                            'answer' => 'I specialize in Laravel (PHP), Vue.js, React, Node.js, and modern CSS frameworks like Tailwind CSS. I also have extensive experience with databases (MySQL, PostgreSQL, MongoDB) and cloud services (AWS, DigitalOcean).'
                        ],
                        [
                            'question' => 'How do you handle project pricing?',
                            'answer' => 'I offer flexible pricing models including fixed-price for well-defined projects and hourly rates for ongoing work. Each project is unique, so I provide detailed quotes after understanding your specific requirements.'
                        ],
                    ];
                @endphp
                
                @foreach($faqs as $index => $faq)
                    <div x-data="{ open: false }" 
                         class="border border-white/5 bg-white/[0.01] overflow-hidden"
                         data-aos="fade-up"
                         data-aos-delay="{{ $index * 50 }}">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between p-6 text-left hover:bg-white/[0.02] transition-colors duration-300">
                            <span class="text-sm font-medium tracking-wider pr-8">{{ $faq['question'] }}</span>
                            <svg class="w-5 h-5 flex-shrink-0 text-white/30 transition-transform duration-300"
                                 :class="{ 'rotate-45': open }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 max-h-0"
                             x-transition:enter-end="opacity-100 max-h-96"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 max-h-96"
                             x-transition:leave-end="opacity-0 max-h-0"
                             class="border-t border-white/5"
                             style="display: none;">
                            <p class="p-6 text-sm text-white/50 leading-relaxed">
                                {{ $faq['answer'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    {{-- Map Section (Optional) --}}
    @if(isset($contactInfo['show_map']) && $contactInfo['show_map'])
        <section class="h-[400px] bg-gray-900 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-12 h-12 text-white/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-white/30 text-sm tracking-wider">{{ $contactInfo['location'] ?? 'Location' }}</p>
                </div>
            </div>
            {{-- Map placeholder - Replace with actual map integration --}}
            <div class="w-full h-full bg-gray-800"></div>
        </section>
    @endif
    
    {{-- Availability Section --}}
    <section class="py-20 lg:py-28 px-6 lg:px-16 bg-gradient-to-b from-black to-gray-950 text-center border-t border-white/5">
        <div class="max-w-3xl mx-auto" data-aos="fade-up">
            <div class="inline-flex items-center space-x-2 px-6 py-3 border border-emerald-500/20 rounded-full mb-8">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-sm text-emerald-400/80">Available for new projects</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold tracking-[0.05em] mb-6">
                READY TO START YOUR PROJECT?
            </h2>
            <p class="text-white/40 text-lg mb-10">
                Let's create something amazing together. I'm just a message away.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:{{ $contactInfo['email'] ?? 'hello@yourdomain.com' }}" 
                   class="inline-flex items-center justify-center px-10 py-4 border border-white/30 text-white text-sm tracking-[0.2em] font-medium hover:bg-white hover:text-black transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    EMAIL ME
                </a>
                <a href="tel:{{ $contactInfo['phone'] ?? '+1234567890' }}" 
                   class="inline-flex items-center justify-center px-10 py-4 border border-white/10 text-white/60 text-sm tracking-[0.2em] font-medium hover:border-white/30 hover:text-white transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    CALL ME
                </a>
            </div>
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