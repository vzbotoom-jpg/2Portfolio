<?php

// database/seeders/ProjectSeeder.php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'category' => 'WEB APPLICATION',
                'description' => 'A full-featured e-commerce solution with real-time inventory management, payment gateway integration, and comprehensive admin dashboard. Built with scalability and performance in mind.',
                'short_description' => 'Enterprise-level e-commerce platform with real-time inventory management.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'Stripe', 'Docker'],
                'live_url' => 'https://example-ecommerce.com',
                'github_url' => 'https://github.com/yourusername/ecommerce-platform',
                'client' => 'TechCorp Inc.',
                'duration' => '3 months',
                'completed_at' => '2024-01-15',
                'featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'challenges' => 'Implementing real-time inventory sync across multiple warehouses and handling high-traffic during flash sales.',
                'solutions' => 'Used Redis for caching and WebSocket for real-time updates. Implemented queue system for order processing and horizontal scaling with load balancing.',
                'results' => 'Increased sales by 45%, reduced inventory discrepancies by 90%, and handled 10,000+ concurrent users during peak events.',
                'testimonial' => 'Working with this developer was an absolute pleasure. The e-commerce platform delivered exceeded our expectations in every way.',
                'testimonial_author' => 'John Anderson',
                'testimonial_position' => 'CEO, TechCorp Inc.',
            ],
            [
                'title' => 'AI Analytics Dashboard',
                'category' => 'DATA ANALYTICS',
                'description' => 'Real-time analytics dashboard powered by machine learning algorithms for predictive business insights. Features interactive data visualization, customizable reports, and automated anomaly detection.',
                'short_description' => 'AI-powered analytics dashboard with real-time data visualization.',
                'technologies' => ['Python', 'React', 'TensorFlow', 'AWS', 'D3.js', 'PostgreSQL'],
                'live_url' => 'https://example-analytics.com',
                'github_url' => 'https://github.com/yourusername/ai-dashboard',
                'client' => 'DataFlow Analytics',
                'duration' => '4 months',
                'completed_at' => '2024-03-20',
                'featured' => true,
                'is_published' => true,
                'sort_order' => 2,
                'challenges' => 'Processing and visualizing terabytes of data in real-time while maintaining responsive UI.',
                'solutions' => 'Implemented data streaming with AWS Kinesis, optimized React rendering with virtualization, and used Web Workers for heavy computations.',
                'results' => 'Reduced data processing time by 60%, improved decision-making speed by 3x, and achieved 99.9% uptime.',
                'testimonial' => 'The analytics dashboard transformed how we make business decisions. Incredible attention to detail and technical expertise.',
                'testimonial_author' => 'Sarah Chen',
                'testimonial_position' => 'CTO, DataFlow Analytics',
            ],
            [
                'title' => 'Mobile Banking App',
                'category' => 'MOBILE DEVELOPMENT',
                'description' => 'Secure and intuitive mobile banking application with biometric authentication, real-time transactions, and personal finance management tools.',
                'short_description' => 'Secure mobile banking app with biometric authentication.',
                'technologies' => ['Flutter', 'Node.js', 'PostgreSQL', 'Firebase', 'Docker'],
                'live_url' => 'https://example-banking.com',
                'github_url' => null,
                'client' => 'FinTech Solutions',
                'duration' => '6 months',
                'completed_at' => '2024-06-10',
                'featured' => true,
                'is_published' => true,
                'sort_order' => 3,
                'challenges' => 'Ensuring bank-level security and compliance with financial regulations while providing seamless user experience.',
                'solutions' => 'Implemented end-to-end encryption, biometric authentication, and comprehensive audit logging. Used secure enclave for sensitive data.',
                'results' => 'Achieved 99.9% uptime, 5-star rating on app stores, and 100K+ downloads in first month.',
                'testimonial' => 'Exceptional development work. The app is secure, fast, and our users love it.',
                'testimonial_author' => 'Michael Roberts',
                'testimonial_position' => 'Head of Product, FinTech Solutions',
            ],
            [
                'title' => 'Healthcare Management System',
                'category' => 'WEB APPLICATION',
                'description' => 'Comprehensive healthcare management system for patient records, appointment scheduling, billing, and telemedicine integration.',
                'short_description' => 'Healthcare platform with telemedicine and patient management.',
                'technologies' => ['Laravel', 'Livewire', 'MySQL', 'WebRTC', 'Docker'],
                'live_url' => 'https://example-healthcare.com',
                'github_url' => null,
                'client' => 'MediCare Group',
                'duration' => '5 months',
                'completed_at' => '2023-11-30',
                'featured' => false,
                'is_published' => true,
                'sort_order' => 4,
                'challenges' => 'HIPAA compliance, secure patient data management, and integrating with existing hospital systems.',
                'solutions' => 'Implemented role-based access control, data encryption at rest and in transit, and HL7 FHIR standards for interoperability.',
                'results' => 'Streamlined patient management for 50,000+ patients across 5 clinics, reduced administrative work by 40%.',
                'testimonial' => 'The system has revolutionized our patient management. Highly professional and reliable developer.',
                'testimonial_author' => 'Dr. Emily Watson',
                'testimonial_position' => 'Medical Director, MediCare Group',
            ],
            [
                'title' => 'Real Estate Platform',
                'category' => 'WEB APPLICATION',
                'description' => 'Property listing platform with virtual tours, interactive maps, AI-powered property recommendations, and integrated mortgage calculator.',
                'short_description' => 'Real estate platform with virtual tours and AI recommendations.',
                'technologies' => ['Next.js', 'Node.js', 'MongoDB', 'Google Maps API', 'AWS'],
                'live_url' => 'https://example-realestate.com',
                'github_url' => 'https://github.com/yourusername/realestate-platform',
                'client' => 'PropertyFinder',
                'duration' => '4 months',
                'completed_at' => '2023-08-15',
                'featured' => false,
                'is_published' => true,
                'sort_order' => 5,
                'challenges' => 'Integrating 3D virtual tours, handling high-resolution images, and building a fast search engine for thousands of listings.',
                'solutions' => 'Used WebGL for 3D tours, CloudFront CDN for image optimization, and Elasticsearch for fast property search.',
                'results' => 'Increased user engagement by 70%, reduced bounce rate by 40%, and improved search speed by 5x.',
                'testimonial' => 'Outstanding platform that exceeded our expectations. The virtual tour feature is a game-changer.',
                'testimonial_author' => 'David Park',
                'testimonial_position' => 'CEO, PropertyFinder',
            ],
            [
                'title' => 'E-Learning Portal',
                'category' => 'EDUCATION',
                'description' => 'Interactive e-learning platform with video courses, live classes, quizzes, progress tracking, and certification management.',
                'short_description' => 'Interactive e-learning platform with live classes and progress tracking.',
                'technologies' => ['Laravel', 'Vue.js', 'WebRTC', 'FFmpeg', 'MySQL'],
                'live_url' => 'https://example-elearning.com',
                'github_url' => null,
                'client' => 'EduTech Inc.',
                'duration' => '3 months',
                'completed_at' => '2023-05-20',
                'featured' => false,
                'is_published' => true,
                'sort_order' => 6,
                'challenges' => 'Video streaming optimization, real-time collaboration features, and supporting 50,000+ concurrent users.',
                'solutions' => 'Implemented HLS streaming for videos, WebRTC for live classes, and horizontal scaling with Kubernetes.',
                'results' => 'Supported 50,000+ concurrent users with 99.5% uptime. Students completed 100,000+ courses in first quarter.',
                'testimonial' => 'The e-learning platform is robust and user-friendly. Our students and instructors love it.',
                'testimonial_author' => 'Lisa Thompson',
                'testimonial_position' => 'Director, EduTech Inc.',
            ],
        ];

        foreach ($projects as $projectData) {
            $projectData['slug'] = Str::slug($projectData['title']);
            $projectData['image'] = 'projects/project-' . rand(1, 3) . '.webp';
            $projectData['thumbnail'] = 'projects/thumbnails/project-' . rand(1, 3) . '-thumb.webp';
            
            Project::create($projectData);
        }
    }
}