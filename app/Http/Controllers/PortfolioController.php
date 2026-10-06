<?php

// app/Http/Controllers/PortfolioController.php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Hero Section Data
        $heroData = [
            'title' => 'CREATING THE FUTURE',
            'subtitle' => 'Full-Stack Developer & Digital Architect',
            'description' => 'Building innovative digital solutions that push the boundaries of technology and design.',
            'cta_primary' => [
                'text' => 'VIEW PROJECTS',
                'link' => route('projects.index'),
                'icon' => null
            ],
            'cta_secondary' => [
                'text' => 'LEARN MORE',
                'link' => route('about'),
                'icon' => null
            ],
            'background' => [
                'image' => 'images/hero/hero-bg.webp',
                'video' => 'videos/hero-video.mp4',
                'overlay_opacity' => 0.5
            ]
        ];

        // Validate hero file paths — if the referenced video doesn't exist, disable it
        if (! file_exists(public_path($heroData['background']['video']))) {
            $heroData['background']['video'] = null;
        }
        if (! file_exists(public_path($heroData['background']['image']))) {
            $heroData['background']['image'] = null;
        }

        // Statistics Data
        $stats = [
            [
                'number' => '50+',
                'label' => 'PROJECTS COMPLETED',
                'icon' => 'code',
                'description' => 'Successfully delivered across various industries'
            ],
            [
                'number' => '5+',
                'label' => 'YEARS EXPERIENCE',
                'icon' => 'clock',
                'description' => 'In web development & digital solutions'
            ],
            [
                'number' => '30+',
                'label' => 'HAPPY CLIENTS',
                'icon' => 'users',
                'description' => 'From startups to enterprises worldwide'
            ],
            [
                'number' => '15+',
                'label' => 'TECHNOLOGIES',
                'icon' => 'cpu',
                'description' => 'Modern tech stack & frameworks'
            ]
        ];

        // Featured Projects (Latest 3 featured projects)
        $featuredProjects = collect();
        
        try {
            $featuredProjects = Project::where('featured', true)
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        } catch (\Exception $e) {
            Log::error('Failed to fetch featured projects: ' . $e->getMessage());
        }

        // If no projects in database, use fallback data
        if ($featuredProjects->isEmpty()) {
            $featuredProjects = collect([
                [
                    'title' => 'E-Commerce Platform',
                    'slug' => 'ecommerce-platform',
                    'category' => 'WEB APPLICATION',
                    'description' => 'A full-featured e-commerce solution with real-time inventory management.',
                    'image' => 'images/projects/project-1.webp',
                    'thumbnail' => 'images/projects/thumbnails/project-1-thumb.webp',
                    'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis'],
                    'featured' => true,
                    'client' => 'TechCorp Inc.',
                    'duration' => '3 months',
                    'live_url' => 'https://example.com',
                    'github_url' => 'https://github.com/yourusername/project'
                ],
                [
                    'title' => 'AI Analytics Dashboard',
                    'slug' => 'ai-analytics-dashboard',
                    'category' => 'DATA ANALYTICS',
                    'description' => 'Real-time analytics dashboard powered by machine learning algorithms.',
                    'image' => 'images/projects/project-2.webp',
                    'thumbnail' => 'images/projects/thumbnails/project-2-thumb.webp',
                    'technologies' => ['Python', 'React', 'TensorFlow', 'AWS'],
                    'featured' => true,
                    'client' => 'DataFlow Analytics',
                    'duration' => '4 months',
                    'live_url' => 'https://example.com',
                    'github_url' => 'https://github.com/yourusername/project'
                ],
                [
                    'title' => 'Mobile Banking App',
                    'slug' => 'mobile-banking-app',
                    'category' => 'MOBILE DEVELOPMENT',
                    'description' => 'Secure and intuitive mobile banking application with biometric authentication.',
                    'image' => 'images/projects/project-3.webp',
                    'thumbnail' => 'images/projects/thumbnails/project-3-thumb.webp',
                    'technologies' => ['Flutter', 'Node.js', 'PostgreSQL', 'Firebase'],
                    'featured' => true,
                    'client' => 'FinTech Solutions',
                    'duration' => '6 months',
                    'live_url' => 'https://example.com',
                    'github_url' => null
                ]
            ])->map(function ($item) {
                return (object) $item;
            });
        }

        // Skills Data
        $skills = collect();
        
        try {
            $skills = Skill::orderBy('sort_order')
                ->orderBy('category')
                ->get()
                ->groupBy('category');
        } catch (\Exception $e) {
            Log::error('Failed to fetch skills: ' . $e->getMessage());
        }

        // If no skills in database, use fallback
        if ($skills->isEmpty()) {
            $skills = collect([
                'Frontend Development' => collect([
                    ['name' => 'Vue.js / React', 'level' => 90, 'category' => 'Frontend Development'],
                    ['name' => 'HTML5 / CSS3', 'level' => 95, 'category' => 'Frontend Development'],
                    ['name' => 'JavaScript (ES6+)', 'level' => 92, 'category' => 'Frontend Development'],
                    ['name' => 'Tailwind CSS', 'level' => 95, 'category' => 'Frontend Development'],
                ]),
                'Backend Development' => collect([
                    ['name' => 'Laravel / PHP', 'level' => 95, 'category' => 'Backend Development'],
                    ['name' => 'Node.js / Express', 'level' => 85, 'category' => 'Backend Development'],
                    ['name' => 'Python / Django', 'level' => 80, 'category' => 'Backend Development'],
                    ['name' => 'RESTful APIs', 'level' => 92, 'category' => 'Backend Development'],
                ]),
                'Database & DevOps' => collect([
                    ['name' => 'MySQL / PostgreSQL', 'level' => 90, 'category' => 'Database & DevOps'],
                    ['name' => 'MongoDB / Redis', 'level' => 85, 'category' => 'Database & DevOps'],
                    ['name' => 'AWS / Docker', 'level' => 82, 'category' => 'Database & DevOps'],
                    ['name' => 'CI/CD Pipeline', 'level' => 80, 'category' => 'Database & DevOps'],
                ]),
            ]);
        }

        // Project marquee brands
        $projectBrands = [];

        try {
            $projectBrands = Project::published()
                ->ordered()
                ->take(8)
                ->get()
                ->map(function ($project) {
                    return [
                        'name' => $project->title,
                        'url' => $project->live_url ?: route('projects.show', $project),
                        'logo' => $project->thumbnail_url,
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            Log::error('Failed to fetch project marquee brands: ' . $e->getMessage());
        }

        if (empty($projectBrands)) {
            $projectBrands = [
                [
                    'name' => 'E-Commerce Platform',
                    'url' => route('projects.index'),
                    'logo' => asset('images/projects/project-1.webp'),
                ],
                [
                    'name' => 'AI Analytics Dashboard',
                    'url' => route('projects.index'),
                    'logo' => asset('images/projects/project-2.webp'),
                ],
                [
                    'name' => 'Mobile Banking App',
                    'url' => route('projects.index'),
                    'logo' => asset('images/projects/project-3.webp'),
                ],
            ];
        }

        // Services
        $services = collect();
        
        try {
            $services = Service::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        } catch (\Exception $e) {
            Log::error('Failed to fetch services: ' . $e->getMessage());
        }

        if ($services->isEmpty()) {
            $services = collect([
                [
                    'title' => 'Web Development',
                    'description' => 'Custom web applications built with cutting-edge technologies.',
                    'icon' => 'globe',
                    'features' => ['Responsive Design', 'SEO Optimized', 'Performance Focused']
                ],
                [
                    'title' => 'Mobile Apps',
                    'description' => 'Native and cross-platform mobile applications.',
                    'icon' => 'smartphone',
                    'features' => ['iOS & Android', 'Cross-Platform', 'Offline Support']
                ],
                [
                    'title' => 'UI/UX Design',
                    'description' => 'Beautiful and intuitive user interfaces.',
                    'icon' => 'palette',
                    'features' => ['User Research', 'Prototyping', 'Design Systems']
                ],
            ])->map(function ($item) {
                return (object) $item;
            });
        }

        // Testimonials
        $testimonials = collect();
        
        try {
            $testimonials = Testimonial::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        } catch (\Exception $e) {
            Log::error('Failed to fetch testimonials: ' . $e->getMessage());
        }

        if ($testimonials->isEmpty()) {
            $testimonials = collect([
                [
                    'name' => 'John Doe',
                    'position' => 'CEO, TechCorp',
                    'company' => 'TechCorp Inc.',
                    'content' => 'Outstanding work! Delivered beyond our expectations. The attention to detail and technical expertise were impressive.',
                    'rating' => 5,
                    'avatar' => null,
                    'project_name' => 'E-Commerce Platform'
                ],
                [
                    'name' => 'Jane Smith',
                    'position' => 'CTO, StartupX',
                    'company' => 'StartupX',
                    'content' => 'Exceptional developer with great attention to detail. Delivered on time and exceeded our expectations.',
                    'rating' => 5,
                    'avatar' => null,
                    'project_name' => 'Mobile Banking App'
                ],
                [
                    'name' => 'Mike Johnson',
                    'position' => 'Founder, DigitalPro',
                    'company' => 'DigitalPro',
                    'content' => 'Incredible technical skills combined with creative problem-solving. Highly recommended!',
                    'rating' => 5,
                    'avatar' => null,
                    'project_name' => 'AI Analytics Dashboard'
                ],
                [
                    'name' => 'Sarah Williams',
                    'position' => 'Product Manager, InnovateLabs',
                    'company' => 'InnovateLabs',
                    'content' => 'One of the best developers I\'ve worked with. Deep understanding of modern web technologies.',
                    'rating' => 5,
                    'avatar' => null,
                    'project_name' => 'Healthcare Platform'
                ],
            ])->map(function ($item) {
                return (object) $item;
            });
        }

        // Contact Info
        $contactInfo = [
            'email' => 'hello@yourdomain.com',
            'phone' => '+1 234 567 890',
            'location' => 'City, Country',
            'availability' => 'Available for freelance projects',
            'response_time' => 'Within 24 hours',
            'social_links' => [
                'github' => 'https://github.com/yourusername',
                'linkedin' => 'https://linkedin.com/in/yourusername',
                'twitter' => 'https://twitter.com/yourusername',
                'dribbble' => 'https://dribbble.com/yourusername',
                'instagram' => 'https://instagram.com/yourusername'
            ]
        ];

        // SEO Data
        $seoData = [
            'title' => 'Your Name - Full-Stack Developer Portfolio',
            'description' => 'Full-Stack Developer specializing in Laravel, Vue.js, and modern web technologies. Creating digital excellence through innovative solutions.',
            'keywords' => 'web developer, laravel developer, full-stack developer, portfolio, vue.js, react',
            'og_image' => 'images/og-image.jpg',
            'og_type' => 'website',
            'twitter_card' => 'summary_large_image'
        ];

        return view('pages.home', compact(
            'heroData',
            'stats',
            'featuredProjects',
            'skills',
            'services',
            'testimonials',
            'contactInfo',
            'projectBrands',
            'seoData'
        ));
    }

    /**
     * Display projects listing page.
     */
    public function projects(Request $request)
    {
        // Get filter parameters
        $category = $request->get('category');
        $technology = $request->get('technology');
        $search = $request->get('search');
        $sort = $request->get('sort', 'latest');

        // Query projects
        $projectsQuery = Project::where('is_published', true);

        // Apply filters
        if ($category) {
            $projectsQuery->where('category', $category);
        }

        if ($technology) {
            $projectsQuery->whereJsonContains('technologies', $technology);
        }

        if ($search) {
            $projectsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $projectsQuery->orderBy('created_at', 'asc');
                break;
            case 'name':
                $projectsQuery->orderBy('title', 'asc');
                break;
            case 'featured':
                $projectsQuery->orderBy('featured', 'desc')
                    ->orderBy('sort_order');
                break;
            default: // latest
                $projectsQuery->orderBy('created_at', 'desc');
                break;
        }

        // Paginate results
        $projects = $projectsQuery->paginate(9)->withQueryString();

        // Get all unique categories and technologies for filters
        $categories = Project::where('is_published', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $technologies = Project::where('is_published', true)
            ->get()
            ->pluck('technologies')
            ->flatten()
            ->unique()
            ->filter()
            ->values();

        // If no projects, use fallback
        if ($projects->isEmpty()) {
            $fallbackProjects = $this->getFallbackProjects();
            $projects = new \Illuminate\Pagination\LengthAwarePaginator(
                collect($fallbackProjects),
                count($fallbackProjects),
                9,
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
            // Set categories and technologies from fallback
            if ($categories->isEmpty()) {
                $categories = collect(['WEB APPLICATION', 'DATA ANALYTICS', 'MOBILE DEVELOPMENT', 'EDUCATION']);
            }
            if ($technologies->isEmpty()) {
                $technologies = collect(['Laravel', 'Vue.js', 'React', 'Node.js', 'Python', 'MySQL', 'PostgreSQL', 'AWS', 'Docker']);
            }
        }

        $seoData = [
            'title' => 'Projects - Your Name Portfolio',
            'description' => 'Explore my portfolio of web development projects, applications, and digital solutions.',
            'keywords' => 'projects, portfolio, web development, applications'
        ];

        return view('pages.projects.index', compact(
            'projects',
            'categories',
            'technologies',
            'seoData',
            'category',
            'technology',
            'search',
            'sort'
        ));
    }

    /**
     * Display single project detail.
     */
    public function projectDetail($slug)
    {
        // Try to find project in database
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->first();

        // If not found, use fallback
        if (!$project) {
            $fallbackProjects = $this->getFallbackProjects();
            $projectData = collect($fallbackProjects)->firstWhere('slug', $slug);
            
            if (!$projectData) {
                abort(404);
            }
            
            $project = (object) $projectData;
        }

        // Get related projects
        $relatedProjects = collect();
        $nextProject = null;
        $prevProject = null;

        if ($project instanceof Project) {
            // Related projects
            $relatedProjects = Project::where('is_published', true)
                ->where('id', '!=', $project->id)
                ->where(function ($query) use ($project) {
                    $query->where('category', $project->category);
                    
                    if (!empty($project->technologies)) {
                        foreach ((array)$project->technologies as $tech) {
                            $query->orWhereJsonContains('technologies', $tech);
                        }
                    }
                })
                ->take(3)
                ->get();

            // Next project
            $nextProject = Project::where('is_published', true)
                ->where('sort_order', '>', $project->sort_order ?? 0)
                ->orderBy('sort_order', 'asc')
                ->first();

            // Previous project
            $prevProject = Project::where('is_published', true)
                ->where('sort_order', '<', $project->sort_order ?? 0)
                ->orderBy('sort_order', 'desc')
                ->first();
        } else {
            // Fallback related projects
            $relatedProjects = collect($this->getFallbackProjects())
                ->where('slug', '!=', $slug)
                ->take(3)
                ->map(function ($item) {
                    return (object) $item;
                });
        }

        // Get technologies for SEO
        $technologies = $project->technologies ?? [];
        if ($technologies instanceof \Illuminate\Support\Collection) {
            $technologies = $technologies->toArray();
        }

        $seoData = [
            'title' => ($project->title ?? 'Project') . ' - Project Detail',
            'description' => $project->description ?? $project->short_description ?? 'Project detail page',
            'keywords' => is_array($technologies) ? implode(', ', $technologies) : '',
            'og_image' => $project->image_url ?? ($project->image ?? null)
        ];

        return view('pages.projects.show', compact(
            'project',
            'relatedProjects',
            'nextProject',
            'prevProject',
            'seoData'
        ));
    }

    /**
     * Display about page.
     */
    public function about()
    {
        // About page data
        $aboutData = [
            'title' => 'ABOUT ME',
            'subtitle' => 'Passionate Developer & Problem Solver',
            'bio' => [
                [
                    'year' => '2024',
                    'title' => 'Senior Full-Stack Developer',
                    'company' => 'Tech Company',
                    'description' => 'Leading development of enterprise-level applications with focus on scalability and performance.',
                    'technologies' => ['Laravel', 'Vue.js', 'AWS', 'Docker']
                ],
                [
                    'year' => '2022',
                    'title' => 'Full-Stack Developer',
                    'company' => 'Digital Agency',
                    'description' => 'Developed multiple client projects using Laravel and Vue.js. Improved team workflow and code quality.',
                    'technologies' => ['React', 'Node.js', 'PostgreSQL', 'Redis']
                ],
                [
                    'year' => '2020',
                    'title' => 'Junior Developer',
                    'company' => 'Startup Inc',
                    'description' => 'Started career building web applications and learning modern development workflows.',
                    'technologies' => ['PHP', 'JavaScript', 'MySQL', 'Bootstrap']
                ],
            ],
            'education' => [
                [
                    'year' => '2020',
                    'degree' => 'Bachelor of Computer Science',
                    'school' => 'University Name',
                    'description' => 'Major in Software Engineering with focus on web technologies.'
                ]
            ],
            'certifications' => [
                [
                    'name' => 'AWS Certified Developer',
                    'issuer' => 'Amazon Web Services',
                    'year' => '2023'
                ],
                [
                    'name' => 'Laravel Certified Developer',
                    'issuer' => 'Laravel',
                    'year' => '2022'
                ],
                [
                    'name' => 'Google Cloud Professional',
                    'issuer' => 'Google Cloud',
                    'year' => '2021'
                ]
            ]
        ];

        // Get skills for about page
        $skills = collect();
        
        try {
            $skills = Skill::orderBy('sort_order')
                ->orderBy('category')
                ->get()
                ->groupBy('category');
        } catch (\Exception $e) {
            Log::error('Failed to fetch skills: ' . $e->getMessage());
        }

        // Fallback skills
        if ($skills->isEmpty()) {
            $skills = collect([
                'Frontend Development' => collect([
                    ['name' => 'Vue.js / React', 'level' => 90],
                    ['name' => 'HTML5 / CSS3', 'level' => 95],
                    ['name' => 'JavaScript (ES6+)', 'level' => 92],
                    ['name' => 'Tailwind CSS', 'level' => 95],
                ]),
                'Backend Development' => collect([
                    ['name' => 'Laravel / PHP', 'level' => 95],
                    ['name' => 'Node.js / Express', 'level' => 85],
                    ['name' => 'Python / Django', 'level' => 80],
                    ['name' => 'RESTful APIs', 'level' => 92],
                ]),
                'Database & DevOps' => collect([
                    ['name' => 'MySQL / PostgreSQL', 'level' => 90],
                    ['name' => 'MongoDB / Redis', 'level' => 85],
                    ['name' => 'AWS / Docker', 'level' => 82],
                    ['name' => 'CI/CD Pipeline', 'level' => 80],
                ]),
            ]);
        }

        $seoData = [
            'title' => 'About Me - Your Name',
            'description' => 'Learn more about my experience, skills, and journey as a full-stack developer.',
            'keywords' => 'about me, developer, experience, skills'
        ];

        return view('pages.about', compact('aboutData', 'skills', 'seoData'));
    }

    /**
     * Display contact page.
     */
    public function contact()
    {
        $contactInfo = [
            'email' => 'hello@yourdomain.com',
            'phone' => '+1 234 567 890',
            'location' => 'City, Country',
            'availability' => 'Available for freelance projects',
            'response_time' => 'Within 24 hours',
            'show_map' => false,
            'social_links' => [
                'github' => 'https://github.com/yourusername',
                'linkedin' => 'https://linkedin.com/in/yourusername',
                'twitter' => 'https://twitter.com/yourusername',
                'dribbble' => 'https://dribbble.com/yourusername',
                'instagram' => 'https://instagram.com/yourusername'
            ]
        ];

        $seoData = [
            'title' => 'Contact - Your Name',
            'description' => 'Get in touch with me for project inquiries, collaborations, or just to say hello.',
            'keywords' => 'contact, hire developer, freelance'
        ];

        return view('pages.contact', compact('contactInfo', 'seoData'));
    }

    /**
     * Display services page.
     */
    public function services()
    {
        $services = collect();
        
        try {
            $services = Service::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        } catch (\Exception $e) {
            Log::error('Failed to fetch services: ' . $e->getMessage());
        }

        if ($services->isEmpty()) {
            $services = collect([
                [
                    'title' => 'Web Development',
                    'description' => 'Custom web applications built with cutting-edge technologies for optimal performance and scalability.',
                    'icon' => 'globe',
                    'features' => ['Responsive Design', 'SEO Optimized', 'Performance Focused', 'API Integration']
                ],
                [
                    'title' => 'Mobile Apps',
                    'description' => 'Native and cross-platform mobile applications that deliver exceptional user experiences.',
                    'icon' => 'smartphone',
                    'features' => ['iOS & Android', 'Cross-Platform', 'Offline Support', 'Push Notifications']
                ],
                [
                    'title' => 'UI/UX Design',
                    'description' => 'Beautiful and intuitive user interfaces crafted with meticulous attention to detail.',
                    'icon' => 'palette',
                    'features' => ['User Research', 'Prototyping', 'Design Systems', 'Usability Testing']
                ],
                [
                    'title' => 'Consulting',
                    'description' => 'Technical consulting and architecture planning for your digital projects.',
                    'icon' => 'briefcase',
                    'features' => ['Architecture Planning', 'Code Review', 'Performance Optimization', 'Team Training']
                ],
                [
                    'title' => 'DevOps',
                    'description' => 'Deployment automation and infrastructure management for scalable applications.',
                    'icon' => 'server',
                    'features' => ['CI/CD Pipeline', 'Cloud Services', 'Docker/Kubernetes', 'Monitoring']
                ],
                [
                    'title' => 'API Development',
                    'description' => 'Robust and secure RESTful API development for web and mobile applications.',
                    'icon' => 'code',
                    'features' => ['RESTful APIs', 'GraphQL', 'WebSocket', 'Third-party Integration']
                ],
            ])->map(function ($item) {
                return (object) $item;
            });
        }

        $seoData = [
            'title' => 'Services - Your Name',
            'description' => 'Comprehensive digital solutions including web development, mobile apps, UI/UX design, and consulting.',
            'keywords' => 'services, web development, mobile apps, UI/UX design, consulting'
        ];

        return view('pages.services', compact('services', 'seoData'));
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'budget' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
        ]);

        try {
            // Store contact message in database if model exists
            if (class_exists('\App\Models\ContactMessage')) {
                \App\Models\ContactMessage::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'subject' => $validated['subject'],
                    'message' => $validated['message'],
                    'budget' => $validated['budget'] ?? null,
                    'timeline' => $validated['timeline'] ?? null,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
            
            // Send email notification to site owner
            $recipient = config('mail.contact_recipient') ?? config('mail.from.address');

            if ($recipient) {
                \Illuminate\Support\Facades\Mail::to($recipient)
                    ->send(new \App\Mail\ContactFormMail($validated));
            } else {
                Log::warning('Contact form: no recipient configured (mail.from.address is empty).');
            }

            // Log success
            Log::info('Contact form submitted successfully', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject']
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your message! I will get back to you within 24 hours.'
                ]);
            }

            return redirect()->back()->with('success', 'Thank you for your message! I will get back to you within 24 hours.');
            
        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, something went wrong. Please try again later.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Sorry, something went wrong. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Download resume/CV.
     */
    public function downloadResume()
    {
        $filePath = storage_path('app/public/uploads/resume.pdf');
        
        if (!file_exists($filePath)) {
            // Try alternative paths
            $alternativePaths = [
                public_path('uploads/resume.pdf'),
                public_path('files/resume.pdf'),
                public_path('resume.pdf'),
            ];
            
            foreach ($alternativePaths as $path) {
                if (file_exists($path)) {
                    return response()->download($path, 'your-name-resume.pdf');
                }
            }
            
            abort(404, 'Resume not found. Please check back later.');
        }

        return response()->download($filePath, 'your-name-resume.pdf');
    }

    /**
     * Generate sitemap XML.
     */
    public function sitemap()
    {
        $projects = collect();
        
        try {
            $projects = Project::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            $projects = collect($this->getFallbackProjects())->map(function ($item) {
                return (object) $item;
            });
        }

        $content = view('sitemap', compact('projects'))->render();

        return response($content)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate robots.txt.
     */
    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Sitemap: " . route('sitemap') . "\n";

        return response($content)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Generate PWA manifest.
     */
    public function manifest()
    {
        $icons = [
            [
                'src' => '/images/icons/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
            ],
            [
                'src' => '/images/icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
            [
                'src' => '/images/icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ],
        ];

        // Only include icons that actually exist to avoid 500/404 requests
        $filteredIcons = [];
        foreach ($icons as $icon) {
            $path = public_path(ltrim($icon['src'], '/'));
            if (file_exists($path)) {
                $filteredIcons[] = $icon;
            }
        }

        $manifest = [
            'name' => config('app.name', 'Portfolio'),
            'short_name' => 'Portfolio',
            'description' => config('portfolio.seo.default_description', 'Full-Stack Developer Portfolio'),
            'start_url' => '/',
            'display' => 'standalone',
            'orientation' => 'portrait-primary',
            'background_color' => '#000000',
            'theme_color' => '#000000',
            'icons' => $filteredIcons,
        ];

        return response()->json($manifest);
    }

    /**
     * RSS Feed (Optional).
     */
    public function feed()
    {
        $projects = collect();
        
        try {
            $projects = Project::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get();
        } catch (\Exception $e) {
            $projects = collect($this->getFallbackProjects())->map(function ($item) {
                return (object) $item;
            });
        }

        $content = view('feed', compact('projects'))->render();

        return response($content)
            ->header('Content-Type', 'application/rss+xml');
    }

    /**
     * Get fallback projects data.
     */
    private function getFallbackProjects()
    {
        return [
            [
                'id' => 1,
                'title' => 'E-Commerce Platform',
                'slug' => 'ecommerce-platform',
                'category' => 'WEB APPLICATION',
                'description' => 'A full-featured e-commerce solution with real-time inventory management, payment gateway integration, and admin dashboard.',
                'short_description' => 'Enterprise-level e-commerce platform with real-time inventory management.',
                'image' => 'images/projects/project-1.webp',
                'thumbnail' => 'images/projects/thumbnails/project-1-thumb.webp',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'Stripe'],
                'live_url' => 'https://example.com',
                'github_url' => 'https://github.com/yourusername/ecommerce-platform',
                'featured' => true,
                'sort_order' => 1,
                'is_published' => true,
                'client' => 'TechCorp Inc.',
                'duration' => '3 months',
                'completed_at' => '2024-01-15',
                'challenges' => 'Implementing real-time inventory sync across multiple warehouses and handling high-traffic during peak sales.',
                'solutions' => 'Used Redis for caching and WebSocket for real-time updates. Implemented queue system for order processing.',
                'results' => 'Increased sales by 45% and reduced inventory discrepancies by 90%.',
                'testimonial' => 'Working with this developer was an absolute pleasure. The e-commerce platform exceeded our expectations.',
                'testimonial_author' => 'John Anderson',
                'testimonial_position' => 'CEO, TechCorp Inc.',
            ],
            [
                'id' => 2,
                'title' => 'AI Analytics Dashboard',
                'slug' => 'ai-analytics-dashboard',
                'category' => 'DATA ANALYTICS',
                'description' => 'Real-time analytics dashboard powered by machine learning algorithms for predictive business insights.',
                'short_description' => 'AI-powered analytics dashboard with real-time data visualization.',
                'image' => 'images/projects/project-2.webp',
                'thumbnail' => 'images/projects/thumbnails/project-2-thumb.webp',
                'technologies' => ['Python', 'React', 'TensorFlow', 'AWS', 'D3.js'],
                'live_url' => 'https://example.com',
                'github_url' => 'https://github.com/yourusername/ai-dashboard',
                'featured' => true,
                'sort_order' => 2,
                'is_published' => true,
                'client' => 'DataFlow Analytics',
                'duration' => '4 months',
                'completed_at' => '2024-03-20',
                'challenges' => 'Processing and visualizing large datasets in real-time while maintaining responsive UI.',
                'solutions' => 'Implemented data streaming with AWS Kinesis and optimized React rendering with virtualization.',
                'results' => 'Reduced data processing time by 60% and improved decision-making speed by 3x.',
                'testimonial' => 'The analytics dashboard transformed how we make decisions. Incredible work!',
                'testimonial_author' => 'Sarah Chen',
                'testimonial_position' => 'CTO, DataFlow Analytics',
            ],
            [
                'id' => 3,
                'title' => 'Mobile Banking App',
                'slug' => 'mobile-banking-app',
                'category' => 'MOBILE DEVELOPMENT',
                'description' => 'Secure and intuitive mobile banking application with biometric authentication and real-time transactions.',
                'short_description' => 'Secure mobile banking app with biometric authentication.',
                'image' => 'images/projects/project-3.webp',
                'thumbnail' => 'images/projects/thumbnails/project-3-thumb.webp',
                'technologies' => ['Flutter', 'Node.js', 'PostgreSQL', 'Firebase'],
                'live_url' => 'https://example.com',
                'github_url' => null,
                'featured' => true,
                'sort_order' => 3,
                'is_published' => true,
                'client' => 'FinTech Solutions',
                'duration' => '6 months',
                'completed_at' => '2024-06-10',
                'challenges' => 'Ensuring bank-level security and compliance with financial regulations.',
                'solutions' => 'Implemented end-to-end encryption and biometric authentication with comprehensive audit logging.',
                'results' => 'Achieved 99.9% uptime and 5-star rating on app stores with 100K+ downloads.',
                'testimonial' => 'Exceptional development work. The app is secure, fast, and our users love it.',
                'testimonial_author' => 'Michael Roberts',
                'testimonial_position' => 'Head of Product, FinTech Solutions',
            ],
            [
                'id' => 4,
                'title' => 'Healthcare Management System',
                'slug' => 'healthcare-management-system',
                'category' => 'WEB APPLICATION',
                'description' => 'Comprehensive healthcare management system for patient records, appointments, and billing.',
                'short_description' => 'Healthcare platform with patient management and telemedicine.',
                'image' => 'images/projects/project-1.webp',
                'thumbnail' => 'images/projects/thumbnails/project-1-thumb.webp',
                'technologies' => ['Laravel', 'Livewire', 'MySQL', 'Docker'],
                'live_url' => 'https://example.com',
                'github_url' => null,
                'featured' => false,
                'sort_order' => 4,
                'is_published' => true,
                'client' => 'MediCare Group',
                'duration' => '5 months',
                'completed_at' => '2023-11-30',
                'challenges' => 'HIPAA compliance and secure patient data management.',
                'solutions' => 'Implemented role-based access control, data encryption, and comprehensive audit trails.',
                'results' => 'Streamlined patient management for 10,000+ patients across 5 clinics.',
                'testimonial' => 'The system has revolutionized our patient management. Highly professional developer.',
                'testimonial_author' => 'Dr. Emily Watson',
                'testimonial_position' => 'Medical Director, MediCare Group',
            ],
            [
                'id' => 5,
                'title' => 'Real Estate Platform',
                'slug' => 'real-estate-platform',
                'category' => 'WEB APPLICATION',
                'description' => 'Property listing platform with virtual tours, map integration, and AI-powered recommendations.',
                'short_description' => 'Real estate platform with virtual tours and AI recommendations.',
                'image' => 'images/projects/project-2.webp',
                'thumbnail' => 'images/projects/thumbnails/project-2-thumb.webp',
                'technologies' => ['Next.js', 'Node.js', 'MongoDB', 'Google Maps API'],
                'live_url' => 'https://example.com',
                'github_url' => 'https://github.com/yourusername/realestate-platform',
                'featured' => false,
                'sort_order' => 5,
                'is_published' => true,
                'client' => 'PropertyFinder',
                'duration' => '4 months',
                'completed_at' => '2023-08-15',
                'challenges' => 'Integrating virtual tours and handling high-resolution images with fast search capabilities.',
                'solutions' => 'Used WebGL for 3D tours, CloudFront for image optimization, and Elasticsearch for search.',
                'results' => 'Increased user engagement by 70% and reduced bounce rate by 40%.',
                'testimonial' => 'Outstanding platform that exceeded our expectations. The virtual tour feature is a game-changer.',
                'testimonial_author' => 'David Park',
                'testimonial_position' => 'CEO, PropertyFinder',
            ],
            [
                'id' => 6,
                'title' => 'E-Learning Portal',
                'slug' => 'elearning-portal',
                'category' => 'EDUCATION',
                'description' => 'Interactive e-learning platform with video courses, quizzes, and progress tracking.',
                'short_description' => 'Interactive e-learning platform with live classes and progress tracking.',
                'image' => 'images/projects/project-3.webp',
                'thumbnail' => 'images/projects/thumbnails/project-3-thumb.webp',
                'technologies' => ['Laravel', 'Vue.js', 'WebRTC', 'FFmpeg'],
                'live_url' => 'https://example.com',
                'github_url' => null,
                'featured' => false,
                'sort_order' => 6,
                'is_published' => true,
                'client' => 'EduTech Inc.',
                'duration' => '3 months',
                'completed_at' => '2023-05-20',
                'challenges' => 'Video streaming optimization and real-time collaboration features.',
                'solutions' => 'Implemented HLS streaming and WebRTC for live classes with auto-scaling infrastructure.',
                'results' => 'Supported 50,000+ concurrent users with 99.5% uptime.',
                'testimonial' => 'The e-learning platform is robust and user-friendly. Our students and instructors love it.',
                'testimonial_author' => 'Lisa Thompson',
                'testimonial_position' => 'Director, EduTech Inc.',
            ],
        ];
    }
}