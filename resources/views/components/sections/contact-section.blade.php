{{-- resources/views/components/sections/contact-section.blade.php --}}
@props([
    'title' => 'GET IN TOUCH',
    'subtitle' => null,
    'contactInfo' => [],
    'showMap' => false,
])

@php
    $contactInfo = !empty($contactInfo) ? (object) $contactInfo : (object) [
        'email' => 'hello@yourdomain.com',
        'phone' => '+1 234 567 890',
        'location' => 'City, Country',
        'availability' => 'Available for freelance projects',
        'response_time' => 'Within 24 hours',
    ];
@endphp

<section id="contact" class="py-24 lg:py-32 px-6 lg:px-16 bg-black relative overflow-hidden">
    
    {{-- Background Decoration --}}
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/[0.02] rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/[0.01] rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
    
    <div class="max-w-[1400px] mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
            
            {{-- Left Column - Contact Info --}}
            <div data-aos="fade-right">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6 leading-[1.1]">
                    {{ $title }}
                </h2>
                <div class="w-24 h-px bg-white/20 mb-8"></div>
                
                @if($subtitle)
                    <p class="text-white/40 text-lg leading-relaxed mb-12 max-w-xl">
                        {{ $subtitle }}
                    </p>
                @else
                    <p class="text-white/40 text-lg leading-relaxed mb-12 max-w-xl">
                        Have a project in mind? Let's work together to create something extraordinary.
                    </p>
                @endif
                
                {{-- Contact Details --}}
                <div class="space-y-8 mb-12">
                    {{-- Email --}}
                    @if(isset($contactInfo->email))
                        <a href="mailto:{{ $contactInfo->email }}" 
                           class="flex items-center space-x-4 group hoverable">
                            <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center flex-shrink-0 group-hover:border-white/30 group-hover:bg-white/5 transition-all duration-300">
                                <svg class="w-5 h-5 text-white/40 group-hover:text-white transition-colors duration-300" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs tracking-[0.2em] text-white/30 mb-1">EMAIL</div>
                                <div class="text-sm text-white/70 group-hover:text-white transition-colors duration-300">
                                    {{ $contactInfo->email }}
                                </div>
                            </div>
                        </a>
                    @endif
                    
                    {{-- Phone --}}
                    @if(isset($contactInfo->phone))
                        <a href="tel:{{ $contactInfo->phone }}" 
                           class="flex items-center space-x-4 group hoverable">
                            <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center flex-shrink-0 group-hover:border-white/30 group-hover:bg-white/5 transition-all duration-300">
                                <svg class="w-5 h-5 text-white/40 group-hover:text-white transition-colors duration-300" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs tracking-[0.2em] text-white/30 mb-1">PHONE</div>
                                <div class="text-sm text-white/70 group-hover:text-white transition-colors duration-300">
                                    {{ $contactInfo->phone }}
                                </div>
                            </div>
                        </a>
                    @endif
                    
                    {{-- Location --}}
                    @if(isset($contactInfo->location))
                        <div class="flex items-center space-x-4 group">
                            <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center flex-shrink-0 group-hover:border-white/30 group-hover:bg-white/5 transition-all duration-300">
                                <svg class="w-5 h-5 text-white/40 group-hover:text-white transition-colors duration-300" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs tracking-[0.2em] text-white/30 mb-1">LOCATION</div>
                                <div class="text-sm text-white/70">
                                    {{ $contactInfo->location }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                {{-- Availability & Response Time --}}
                <div class="flex flex-wrap gap-6">
                    @if(isset($contactInfo->availability))
                        <div class="flex items-center space-x-2 px-4 py-2 border border-white/10 rounded-full">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <span class="text-xs text-white/50">{{ $contactInfo->availability }}</span>
                        </div>
                    @endif
                    @if(isset($contactInfo->response_time))
                        <div class="flex items-center space-x-2 px-4 py-2 border border-white/10 rounded-full">
                            <svg class="w-3 h-3 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs text-white/50">{{ $contactInfo->response_time }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Right Column - Contact Form --}}
            <div class="relative" data-aos="fade-left">
                <div class="bg-white/[0.02] border border-white/5 p-8 lg:p-10 backdrop-blur-sm">
                    <h3 class="text-xl tracking-[0.2em] font-bold mb-8">SEND A MESSAGE</h3>
                    
                    <form action="{{ route('contact.submit') }}" 
                          method="POST" 
                          class="space-y-6"
                          x-data="contactForm()"
                          @submit.prevent="submitForm">
                        @csrf
                        
                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-xs tracking-[0.2em] text-white/40 mb-2">NAME</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   x-model="formData.name"
                                   required
                                   class="w-full bg-transparent border-b border-white/10 px-0 py-3 text-white placeholder-white/10 focus:outline-none focus:border-white/40 transition-colors duration-300 text-sm"
                                   placeholder="Your name">
                        </div>
                        
                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs tracking-[0.2em] text-white/40 mb-2">EMAIL</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   x-model="formData.email"
                                   required
                                   class="w-full bg-transparent border-b border-white/10 px-0 py-3 text-white placeholder-white/10 focus:outline-none focus:border-white/40 transition-colors duration-300 text-sm"
                                   placeholder="Your email">
                        </div>
                        
                        {{-- Subject --}}
                        <div>
                            <label for="subject" class="block text-xs tracking-[0.2em] text-white/40 mb-2">SUBJECT</label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   x-model="formData.subject"
                                   required
                                   class="w-full bg-transparent border-b border-white/10 px-0 py-3 text-white placeholder-white/10 focus:outline-none focus:border-white/40 transition-colors duration-300 text-sm"
                                   placeholder="Project inquiry">
                        </div>
                        
                        {{-- Budget (Optional) --}}
                        <div>
                            <label for="budget" class="block text-xs tracking-[0.2em] text-white/40 mb-2">BUDGET (OPTIONAL)</label>
                            <select id="budget" 
                                    name="budget" 
                                    x-model="formData.budget"
                                    class="w-full bg-transparent border-b border-white/10 px-0 py-3 text-white/60 focus:outline-none focus:border-white/40 transition-colors duration-300 text-sm cursor-pointer">
                                <option value="" class="bg-black">Select budget range</option>
                                <option value="< $1,000" class="bg-black">Less than $1,000</option>
                                <option value="$1,000 - $5,000" class="bg-black">$1,000 - $5,000</option>
                                <option value="$5,000 - $10,000" class="bg-black">$5,000 - $10,000</option>
                                <option value="$10,000 - $25,000" class="bg-black">$10,000 - $25,000</option>
                                <option value="$25,000+" class="bg-black">$25,000+</option>
                            </select>
                        </div>
                        
                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-xs tracking-[0.2em] text-white/40 mb-2">MESSAGE</label>
                            <textarea id="message" 
                                      name="message" 
                                      x-model="formData.message"
                                      rows="5"
                                      required
                                      class="w-full bg-transparent border border-white/10 p-4 text-white placeholder-white/10 focus:outline-none focus:border-white/40 transition-colors duration-300 text-sm resize-none"
                                      placeholder="Tell me about your project..."></textarea>
                        </div>
                        
                        {{-- Submit Button --}}
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full relative overflow-hidden border border-white/30 text-white px-8 py-4 text-sm tracking-[0.2em] font-medium group transition-all duration-500"
                                    :disabled="isSubmitting">
                                <span class="relative z-10 flex items-center justify-center space-x-3"
                                      x-show="!isSubmitting">
                                    <span>SEND MESSAGE</span>
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </span>
                                <span class="relative z-10 flex items-center justify-center space-x-2"
                                      x-show="isSubmitting">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>SENDING...</span>
                                </span>
                                <div class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                            </button>
                        </div>
                        
                        {{-- Success Message --}}
                        <div x-show="success" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm text-center"
                             style="display: none;">
                            <svg class="w-5 h-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="successMessage"></span>
                        </div>
                        
                        {{-- Error Message --}}
                        <div x-show="error" 
                             x-transition:enter="transition ease-out duration-300"
                             class="p-4 bg-red-500/10 border border-red-500/20 text-red-400 text-sm text-center"
                             style="display: none;">
                            <span x-text="errorMessage"></span>
                        </div>
                    </form>
                </div>
                
                {{-- Decorative Corner --}}
                <div class="absolute -top-4 -right-4 w-8 h-8 border-t border-r border-white/10 hidden lg:block"></div>
                <div class="absolute -bottom-4 -left-4 w-8 h-8 border-b border-l border-white/10 hidden lg:block"></div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function contactForm() {
        return {
            formData: {
                name: '',
                email: '',
                subject: '',
                budget: '',
                message: ''
            },
            isSubmitting: false,
            success: false,
            error: false,
            successMessage: 'Thank you! Your message has been sent successfully.',
            errorMessage: 'Something went wrong. Please try again.',

            async submitForm() {
                this.isSubmitting = true;
                this.success = false;
                this.error = false;

                try {
                    const response = await fetch('{{ route("contact.submit") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const data = await response.json();

                    // Laravel validation failures return HTTP 422 with an "errors" object
                    if (response.status === 422 && data.errors) {
                        const firstField = Object.keys(data.errors)[0];
                        throw new Error(data.errors[firstField][0]);
                    }

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to send message');
                    }

                    this.success = true;
                    this.successMessage = data.message || this.successMessage;
                    this.formData = { name: '', email: '', subject: '', budget: '', message: '' };

                } catch (err) {
                    this.error = true;
                    this.errorMessage = err.message || this.errorMessage;
                } finally {
                    this.isSubmitting = false;

                    setTimeout(() => {
                        this.success = false;
                        this.error = false;
                    }, 5000);
                }
            }
        }
    }
</script>
@endpush