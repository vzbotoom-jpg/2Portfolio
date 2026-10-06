<?php

// config/seo.php

return [
    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the default SEO configuration for the portfolio.
    | These values can be overridden on a per-page basis.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */
    'site_name' => env('SEO_SITE_NAME', 'Portfolio'),
    'site_description' => env('SEO_SITE_DESCRIPTION', 'Full-Stack Developer Portfolio'),
    'author' => env('SEO_AUTHOR', 'Your Name'),
    'author_url' => env('SEO_AUTHOR_URL', 'https://yourdomain.com'),

    /*
    |--------------------------------------------------------------------------
    | Default Meta Tags
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'title' => 'Portfolio - Full-Stack Developer',
        'description' => 'Full-Stack Developer specializing in Laravel, Vue.js, React, and modern web technologies. Creating exceptional digital experiences.',
        'keywords' => 'web developer, full-stack developer, laravel, vue.js, react, portfolio, web development',
        'robots' => 'index, follow',
        'canonical' => null, // Auto-generated from current URL
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph Defaults
    |--------------------------------------------------------------------------
    */
    'open_graph' => [
        'type' => 'website',
        'site_name' => 'Portfolio',
        'locale' => 'en_US',
        'image' => '/images/og-image.jpg',
        'image_width' => 1200,
        'image_height' => 630,
        'image_type' => 'image/jpeg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Defaults
    |--------------------------------------------------------------------------
    */
    'twitter' => [
        'card' => 'summary_large_image',
        'site' => '@yourusername',
        'creator' => '@yourusername',
        'image' => '/images/twitter-card.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON-LD / Structured Data
    |--------------------------------------------------------------------------
    */
    'json_ld' => [
        'organization' => [
            'enabled' => true,
            'type' => 'Person',
            'name' => 'Your Name',
            'url' => 'https://yourdomain.com',
            'image' => '/images/about/profile.webp',
            'jobTitle' => 'Full-Stack Developer',
            'sameAs' => [
                'https://github.com/yourusername',
                'https://linkedin.com/in/yourusername',
                'https://twitter.com/yourusername',
            ],
        ],
        'website' => [
            'enabled' => true,
            'type' => 'WebSite',
            'name' => 'Portfolio',
            'url' => 'https://yourdomain.com',
        ],
        'breadcrumb' => [
            'enabled' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Configuration
    |--------------------------------------------------------------------------
    */
    'sitemap' => [
        'enabled' => true,
        'auto_generate' => true,
        'include_pages' => [
            'home',
            'about',
            'projects.index',
            'projects.show',
            'contact',
        ],
        'exclude_urls' => [
            '/admin/*',
            '/login',
            '/register',
            '/password/*',
        ],
        'change_frequency' => [
            'home' => 'weekly',
            'projects.index' => 'daily',
            'projects.show' => 'monthly',
            'about' => 'monthly',
            'contact' => 'yearly',
        ],
        'priority' => [
            'home' => 1.0,
            'projects.index' => 0.9,
            'projects.show' => 0.8,
            'about' => 0.7,
            'contact' => 0.6,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots.txt Configuration
    |--------------------------------------------------------------------------
    */
    'robots' => [
        'enabled' => true,
        'user_agents' => [
            '*' => [
                'allow' => ['/'],
                'disallow' => ['/admin/', '/login', '/register'],
            ],
        ],
        'sitemap_url' => '/sitemap.xml',
    ],

    /*
    |--------------------------------------------------------------------------
    | Meta Tags for Specific Pages
    |--------------------------------------------------------------------------
    */
    'pages' => [
        'home' => [
            'title' => 'Home - Full-Stack Developer Portfolio',
            'description' => 'Full-Stack Developer creating innovative digital solutions. Explore my portfolio of web development projects.',
            'keywords' => 'portfolio, developer, web development, laravel, vue.js',
        ],
        'projects' => [
            'title' => 'Projects - Portfolio',
            'description' => 'Explore my portfolio of web development projects, applications, and digital solutions.',
            'keywords' => 'projects, portfolio, web development, applications',
        ],
        'about' => [
            'title' => 'About Me - Portfolio',
            'description' => 'Learn more about my experience, skills, and journey as a full-stack developer.',
            'keywords' => 'about, developer, experience, skills, biography',
        ],
        'contact' => [
            'title' => 'Contact - Portfolio',
            'description' => 'Get in touch for project inquiries, collaborations, or just to say hello.',
            'keywords' => 'contact, hire, freelance, developer',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirects (for SEO)
    |--------------------------------------------------------------------------
    */
    'redirects' => [
        // '/old-url' => '/new-url',
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    */
    'security_headers' => [
        'enabled' => true,
        'hsts' => [
            'enabled' => true,
            'max_age' => 31536000,
            'include_subdomains' => true,
            'preload' => true,
        ],
        'x_frame_options' => 'DENY',
        'x_content_type_options' => 'nosniff',
        'referrer_policy' => 'strict-origin-when-cross-origin',
        'permissions_policy' => [
            'camera' => 'none',
            'microphone' => 'none',
            'geolocation' => 'none',
        ],
    ],
];