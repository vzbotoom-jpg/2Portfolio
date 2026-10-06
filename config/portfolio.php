<?php

// config/portfolio.php

return [
    /*
    |--------------------------------------------------------------------------
    | Portfolio Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all the configuration settings for the portfolio
    | website including personal information, social links, and display
    | preferences.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Personal Information
    |--------------------------------------------------------------------------
    */
    'author' => env('PORTFOLIO_AUTHOR', 'Your Name'),
    'title' => env('PORTFOLIO_TITLE', 'Full-Stack Developer & Digital Architect'),
    'email' => env('PORTFOLIO_EMAIL', 'hello@yourdomain.com'),
    'phone' => env('PORTFOLIO_PHONE', '+1 234 567 890'),
    'location' => env('PORTFOLIO_LOCATION', 'City, Country'),
    'availability' => env('PORTFOLIO_AVAILABILITY', 'Available for freelance projects'),
    'response_time' => env('PORTFOLIO_RESPONSE_TIME', 'Within 24 hours'),
    'timezone' => env('PORTFOLIO_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Experience
    |--------------------------------------------------------------------------
    */
    'years_of_experience' => 5,
    'projects_completed' => 50,
    'happy_clients' => 30,
    'technologies_count' => 15,

    /*
    |--------------------------------------------------------------------------
    | Hero Section
    |--------------------------------------------------------------------------
    */
    'hero' => [
        'title' => env('PORTFOLIO_HERO_TITLE', 'CREATING THE FUTURE'),
        'subtitle' => env('PORTFOLIO_HERO_SUBTITLE', 'Full-Stack Developer & Digital Architect'),
        'description' => env('PORTFOLIO_HERO_DESCRIPTION', 'Building innovative digital solutions that push the boundaries of technology and design.'),
        'background_image' => env('PORTFOLIO_HERO_IMAGE', 'images/hero/hero-bg.webp'),
        'background_video' => env('PORTFOLIO_HERO_VIDEO', null),
        'overlay_opacity' => env('PORTFOLIO_HERO_OVERLAY', 0.5),
        'show_scroll_indicator' => true,
        'particles' => env('PORTFOLIO_HERO_PARTICLES', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Links
    |--------------------------------------------------------------------------
    */
    'social' => [
        'github' => env('PORTFOLIO_GITHUB', 'https://github.com/yourusername'),
        'linkedin' => env('PORTFOLIO_LINKEDIN', 'https://linkedin.com/in/yourusername'),
        'twitter' => env('PORTFOLIO_TWITTER', 'https://twitter.com/yourusername'),
        'dribbble' => env('PORTFOLIO_DRIBBBLE', 'https://dribbble.com/yourusername'),
        'instagram' => env('PORTFOLIO_INSTAGRAM', 'https://instagram.com/yourusername'),
        'youtube' => env('PORTFOLIO_YOUTUBE', null),
        'medium' => env('PORTFOLIO_MEDIUM', null),
        'devto' => env('PORTFOLIO_DEVTO', null),
        'stackoverflow' => env('PORTFOLIO_STACKOVERFLOW', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Resume
    |--------------------------------------------------------------------------
    */
    'resume' => [
        'file_path' => 'uploads/resume.pdf',
        'file_name' => 'your-name-resume.pdf',
        'last_updated' => '2024-01-01',
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */
    'navigation' => [
        'logo' => env('PORTFOLIO_LOGO_TEXT', 'PORTFOLIO'),
        'logo_image' => env('PORTFOLIO_LOGO_IMAGE', null),
        'show_cta' => true,
        'cta_text' => 'HIRE ME',
        'sticky' => true,
        'transparent' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    */
    'footer' => [
        'description' => 'Building the future, one line of code at a time.',
        'show_newsletter' => false,
        'bottom_text' => 'DESIGNED WITH PRECISION',
        'copyright_text' => null, // Auto-generated with year if null
    ],

    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */
    'projects' => [
        'per_page' => 9,
        'default_sort' => 'latest',
        'show_filters' => true,
        'featured_count' => 3,
        'related_count' => 3,
        'image_disk' => 'public',
        'image_path' => 'projects',
        'thumbnail_path' => 'projects/thumbnails',
        'placeholder_image' => 'images/projects/placeholder.webp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Skills
    |--------------------------------------------------------------------------
    */
    'skills' => [
        'categories' => [
            'Frontend Development',
            'Backend Development',
            'Database & DevOps',
            'Design & Tools',
            'Other',
        ],
        'level_thresholds' => [
            'expert' => 90,
            'advanced' => 70,
            'intermediate' => 50,
            'basic' => 30,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Form
    |--------------------------------------------------------------------------
    */
    'contact' => [
        'enable_form' => true,
        'notification_email' => env('PORTFOLIO_CONTACT_EMAIL', 'hello@yourdomain.com'),
        'store_messages' => true,
        'show_faq' => true,
        'show_map' => false,
        'budget_options' => [
            '< $1,000',
            '$1,000 - $5,000',
            '$5,000 - $10,000',
            '$10,000 - $25,000',
            '$25,000+',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Testimonials
    |--------------------------------------------------------------------------
    */
    'testimonials' => [
        'per_page' => 6,
        'show_ratings' => true,
        'enable_carousel' => false,
        'autoplay_speed' => 5000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */
    'services' => [
        'show_pricing' => false,
        'currency' => 'USD',
        'pricing_format' => 'starting_at', // starting_at, range, custom
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics & Tracking
    |--------------------------------------------------------------------------
    */
    'analytics' => [
        'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', null),
        'google_tag_manager_id' => env('GOOGLE_TAG_MANAGER_ID', null),
        'facebook_pixel_id' => env('FACEBOOK_PIXEL_ID', null),
        'hotjar_id' => env('HOTJAR_ID', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Defaults
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'default_title' => 'Portfolio - Full-Stack Developer',
        'title_separator' => '|',
        'default_description' => 'Full-Stack Developer specializing in Laravel, Vue.js, and modern web technologies.',
        'default_keywords' => 'web developer, full-stack developer, laravel, portfolio',
        'default_image' => 'images/og-image.jpg',
        'twitter_handle' => '@yourusername',
        'site_name' => 'Portfolio',
        'locale' => 'en_US',
    ],

    /*
    |--------------------------------------------------------------------------
    | PWA / Service Worker
    |--------------------------------------------------------------------------
    */
    'pwa' => [
        'enabled' => env('PORTFOLIO_PWA_ENABLED', false),
        'name' => 'Portfolio',
        'short_name' => 'Portfolio',
        'description' => 'Full-Stack Developer Portfolio',
        'background_color' => '#000000',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'portrait-primary',
        'start_url' => '/',
        'icons' => [
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
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Blog (Optional)
    |--------------------------------------------------------------------------
    */
    'blog' => [
        'enabled' => env('PORTFOLIO_BLOG_ENABLED', false),
        'posts_per_page' => 6,
        'show_author' => true,
        'show_date' => true,
        'show_categories' => true,
        'enable_comments' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    'admin' => [
        'route_prefix' => 'admin',
        'pagination_per_page' => 15,
        'enable_activity_log' => true,
        'image_max_size' => 5120, // 5MB in KB
        'allowed_image_types' => ['jpeg', 'png', 'webp', 'svg'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Settings
    |--------------------------------------------------------------------------
    */
    'maintenance' => [
        'enabled' => env('PORTFOLIO_MAINTENANCE', false),
        'title' => 'We\'ll Be Right Back',
        'description' => 'The site is currently undergoing scheduled maintenance. Please check back soon.',
        'allowed_ips' => [],
        'retry_after' => 3600,
    ],
];