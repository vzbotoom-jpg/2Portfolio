<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceController extends Controller
{
    /**
     * Static service data. Each key is the slug used in the URL
     * (/services/{slug}). Move this into a database table later
     * (e.g. a `services` migration + model) without changing any
     * route or view — just swap how $services is fetched.
     */
    protected function services(): array
    {
        return [
            'web-development' => [
                'title' => 'Web Development',
                'icon' => 'globe',
                'excerpt' => 'Custom web applications built with cutting-edge technologies for optimal performance and scalability.',
                'description' => 'I build full-stack web applications end to end — from database design and backend APIs to responsive, accessible frontends. Every project is built with performance, SEO, and long-term maintainability in mind, using modern frameworks like Laravel, Vue.js, and React.',
                'features' => [
                    'Responsive Design',
                    'SEO Optimized',
                    'Performance Focused',
                    'RESTful API Development',
                    'Database Architecture',
                    'Third-Party Integrations',
                ],
                'process' => [
                    ['title' => 'Discovery', 'description' => 'Understanding your goals, audience, and technical requirements.'],
                    ['title' => 'Design & Architecture', 'description' => 'Planning the data model, API structure, and UI flow before writing code.'],
                    ['title' => 'Development', 'description' => 'Building in iterative, testable increments with regular check-ins.'],
                    ['title' => 'Launch & Support', 'description' => 'Deployment, monitoring, and ongoing maintenance after go-live.'],
                ],
            ],
            'mobile-apps' => [
                'title' => 'Mobile Apps',
                'icon' => 'smartphone',
                'excerpt' => 'Native and cross-platform mobile applications that deliver exceptional user experiences.',
                'description' => 'I design and develop mobile applications for iOS and Android using cross-platform tools, so you reach both audiences from a single, maintainable codebase — without compromising on native-feeling performance or offline reliability.',
                'features' => [
                    'iOS & Android',
                    'Cross-Platform',
                    'Offline Support',
                    'Push Notifications',
                    'App Store Deployment',
                    'Performance Optimization',
                ],
                'process' => [
                    ['title' => 'Discovery', 'description' => 'Defining core flows, target devices, and offline requirements.'],
                    ['title' => 'Prototyping', 'description' => 'Clickable prototypes to validate UX before development starts.'],
                    ['title' => 'Development', 'description' => 'Building and testing across real iOS and Android devices.'],
                    ['title' => 'Store Launch', 'description' => 'Handling App Store / Play Store submission and review.'],
                ],
            ],
            'ui-ux-design' => [
                'title' => 'UI/UX Design',
                'icon' => 'palette',
                'excerpt' => 'Beautiful and intuitive user interfaces crafted with meticulous attention to detail.',
                'description' => 'Good design is invisible — it just works. I focus on clear information hierarchy, accessible interaction patterns, and visual polish that supports your brand, backed by research and iterative testing rather than guesswork.',
                'features' => [
                    'User Research',
                    'Prototyping',
                    'Design Systems',
                    'Usability Testing',
                    'Accessibility (WCAG)',
                    'Design Handoff for Devs',
                ],
                'process' => [
                    ['title' => 'Research', 'description' => 'Talking to users and stakeholders to understand real needs.'],
                    ['title' => 'Wireframing', 'description' => 'Low-fidelity flows to lock in structure before visual design.'],
                    ['title' => 'Visual Design', 'description' => 'High-fidelity screens and a reusable design system / component library.'],
                    ['title' => 'Testing & Iteration', 'description' => 'Validating with real users and refining based on feedback.'],
                ],
            ],
            'consulting' => [
                'title' => 'Consulting',
                'icon' => 'globe',
                'excerpt' => 'Strategic technical guidance to help you make confident decisions about your product.',
                'description' => 'Whether you are choosing a tech stack, reviewing an existing codebase, or planning a roadmap, I provide pragmatic, vendor-neutral advice grounded in real production experience — not buzzwords.',
                'features' => [
                    'Tech Stack Audits',
                    'Code Reviews',
                    'Architecture Planning',
                    'Performance Audits',
                    'Team Mentoring',
                    'Roadmap Planning',
                ],
                'process' => [
                    ['title' => 'Assessment', 'description' => 'Reviewing your current product, codebase, or plans.'],
                    ['title' => 'Findings', 'description' => 'A clear, prioritized report of risks and opportunities.'],
                    ['title' => 'Recommendations', 'description' => 'Concrete, actionable next steps — not just theory.'],
                    ['title' => 'Follow-up', 'description' => 'Optional ongoing advisory as you implement changes.'],
                ],
            ],
        ];
    }

    /**
     * GET /services — overview of all services.
     */
    public function index(): View
    {
        return view('pages.services', [
            'services' => $this->services(),
        ]);
    }

    /**
     * GET /services/{slug} — detail page for a single service.
     */
    public function show(string $slug): View
    {
        $services = $this->services();

        if (! array_key_exists($slug, $services)) {
            throw new NotFoundHttpException("Service [{$slug}] not found.");
        }

        return view('pages.service-detail', [
            'service' => $services[$slug],
            'slug' => $slug,
            'allServices' => $services,
        ]);
    }
}