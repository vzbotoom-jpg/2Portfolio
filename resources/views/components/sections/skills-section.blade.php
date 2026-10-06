{{-- resources/views/components/sections/skills-section.blade.php --}}
@props([
    'skills' => [],
    'title' => 'TECHNICAL EXPERTISE',
    'subtitle' => null,
    'layout' => 'split', // split, grid
])

@php
    $defaultSkills = [
        'Frontend Development' => [
            ['name' => 'Vue.js / React', 'level' => 90],
            ['name' => 'HTML5 / CSS3', 'level' => 95],
            ['name' => 'JavaScript (ES6+)', 'level' => 92],
            ['name' => 'Tailwind CSS', 'level' => 95],
        ],
        'Backend Development' => [
            ['name' => 'Laravel / PHP', 'level' => 95],
            ['name' => 'Node.js / Express', 'level' => 85],
            ['name' => 'Python / Django', 'level' => 80],
            ['name' => 'RESTful APIs', 'level' => 92],
        ],
        'Database & DevOps' => [
            ['name' => 'MySQL / PostgreSQL', 'level' => 90],
            ['name' => 'MongoDB / Redis', 'level' => 85],
            ['name' => 'AWS / Docker', 'level' => 82],
            ['name' => 'CI/CD Pipeline', 'level' => 80],
        ],
    ];
    
    $skills = !empty($skills) ? $skills : $defaultSkills;
@endphp

<section class="py-24 lg:py-32 px-6 lg:px-16 bg-black relative overflow-hidden">
    
    {{-- Background Decoration --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    
    <div class="max-w-[1400px] mx-auto relative z-10">
        
        @if($layout === 'split')
            {{-- Split Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
                
                {{-- Left Column --}}
                <div data-aos="fade-right">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold tracking-[0.05em] mb-6 leading-[1.1]">
                        {{ $title }}
                    </h2>
                    <div class="w-24 h-px bg-white/20 mb-8"></div>
                    @if($subtitle)
                        <p class="text-white/40 text-lg leading-relaxed max-w-xl">
                            {{ $subtitle }}
                        </p>
                    @else
                        <p class="text-white/40 text-lg leading-relaxed max-w-xl">
                            Specializing in modern web technologies and frameworks, I build scalable, 
                            high-performance digital solutions that push the boundaries of what's possible.
                        </p>
                    @endif
                    
                    {{-- Experience Badge --}}
                    <div class="mt-12 inline-flex items-center space-x-4 px-6 py-4 border border-white/10 rounded-sm">
                        <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">5+</div>
                            <div class="text-xs tracking-[0.3em] text-white/40">YEARS EXPERIENCE</div>
                        </div>
                    </div>
                </div>
                
                {{-- Right Column - Skills --}}
                <div class="space-y-16" data-aos="fade-left">
                    @foreach($skills as $category => $categorySkills)
                        <div>
                            <h3 class="text-xs tracking-[0.3em] text-white/30 mb-6 uppercase">
                                {{ $category }}
                            </h3>
                            <div class="space-y-6">
                                @foreach($categorySkills as $index => $skill)
                                    <x-ui.skill-bar 
                                        :name="$skill['name']" 
                                        :level="$skill['level']"
                                        :index="$index"
                                        :animated="true"
                                    />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Grid Layout --}}
            <div class="text-center mb-16" data-aos="fade-up">
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach($skills as $category => $categorySkills)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <h3 class="text-xs tracking-[0.3em] text-white/30 mb-6 uppercase">
                            {{ $category }}
                        </h3>
                        <div class="space-y-6">
                            @foreach($categorySkills as $index => $skill)
                                <x-ui.skill-bar 
                                    :name="$skill['name']" 
                                    :level="$skill['level']"
                                    :index="$index"
                                    :animated="true"
                                />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>