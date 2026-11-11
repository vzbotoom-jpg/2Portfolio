<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'John Doe',
                'position' => 'CEO',
                'company' => 'TechCorp Inc.',
                'content' => 'Outstanding work! Delivered beyond our expectations. The attention to detail and technical expertise were impressive.',
                'rating' => 5,
                'project_name' => 'E-Commerce Platform',
                'is_active' => true,
                'is_featured' => true,
                'verified' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Jane Smith',
                'position' => 'CTO',
                'company' => 'StartupX',
                'content' => 'Exceptional developer with great attention to detail. Delivered on time and exceeded our expectations.',
                'rating' => 5,
                'project_name' => 'Mobile Banking App',
                'is_active' => true,
                'is_featured' => true,
                'verified' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Mike Johnson',
                'position' => 'Founder',
                'company' => 'DigitalPro',
                'content' => 'Incredible technical skills combined with creative problem-solving. Highly recommended!',
                'rating' => 5,
                'project_name' => 'AI Analytics Dashboard',
                'is_active' => true,
                'is_featured' => true,
                'verified' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sarah Williams',
                'position' => 'Product Manager',
                'company' => 'InnovateLabs',
                'content' => 'One of the best developers I\'ve worked with. Deep understanding of modern web technologies.',
                'rating' => 5,
                'project_name' => 'Healthcare Platform',
                'is_active' => true,
                'is_featured' => false,
                'verified' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                [
                    'name' => $testimonial['name'],
                    'company' => $testimonial['company'],
                ],
                $testimonial
            );
        }
    }
}
