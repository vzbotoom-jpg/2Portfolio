<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Custom web applications built with cutting-edge technologies for optimal performance and scalability.',
                'short_description' => 'High-performance web apps built with modern frameworks.',
                'icon' => 'globe',
                'features' => ['Responsive Design', 'SEO Optimized', 'Performance Focused', 'API Integration'],
                'pricing_start' => 1500,
                'pricing_unit' => 'project',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Mobile Apps',
                'description' => 'Native and cross-platform mobile applications that deliver exceptional user experiences.',
                'short_description' => 'Cross-platform mobile applications for iOS and Android.',
                'icon' => 'smartphone',
                'features' => ['iOS & Android', 'Cross-Platform', 'Offline Support', 'Push Notifications'],
                'pricing_start' => 2000,
                'pricing_unit' => 'project',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'Beautiful and intuitive user interfaces crafted with meticulous attention to detail.',
                'short_description' => 'Modern interfaces focused on user engagement and conversion.',
                'icon' => 'palette',
                'features' => ['User Research', 'Prototyping', 'Design Systems', 'Usability Testing'],
                'pricing_start' => 800,
                'pricing_unit' => 'project',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'API Development',
                'description' => 'Robust and secure RESTful API development for web and mobile applications.',
                'short_description' => 'Scalable backend services and API architectures.',
                'icon' => 'code',
                'features' => ['RESTful APIs', 'GraphQL', 'WebSocket', 'Third-party Integration'],
                'pricing_start' => 1000,
                'pricing_unit' => 'project',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            $service['slug'] = Str::slug($service['title']);
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
