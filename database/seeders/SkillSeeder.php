<?php

// database/seeders/SkillSeeder.php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Frontend Development
            [
                'name' => 'Vue.js',
                'category' => 'Frontend Development',
                'level' => 90,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 4,
                'sort_order' => 1,
            ],
            [
                'name' => 'React',
                'category' => 'Frontend Development',
                'level' => 85,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 3,
                'sort_order' => 2,
            ],
            [
                'name' => 'HTML5 / CSS3',
                'category' => 'Frontend Development',
                'level' => 95,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 5,
                'sort_order' => 3,
            ],
            [
                'name' => 'JavaScript (ES6+)',
                'category' => 'Frontend Development',
                'level' => 92,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 5,
                'sort_order' => 4,
            ],
            [
                'name' => 'Tailwind CSS',
                'category' => 'Frontend Development',
                'level' => 95,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 3,
                'sort_order' => 5,
            ],
            [
                'name' => 'Alpine.js',
                'category' => 'Frontend Development',
                'level' => 88,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 2,
                'sort_order' => 6,
            ],
            
            // Backend Development
            [
                'name' => 'Laravel',
                'category' => 'Backend Development',
                'level' => 95,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 5,
                'sort_order' => 7,
            ],
            [
                'name' => 'PHP',
                'category' => 'Backend Development',
                'level' => 92,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 5,
                'sort_order' => 8,
            ],
            [
                'name' => 'Node.js',
                'category' => 'Backend Development',
                'level' => 85,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 3,
                'sort_order' => 9,
            ],
            [
                'name' => 'Python',
                'category' => 'Backend Development',
                'level' => 80,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 2,
                'sort_order' => 10,
            ],
            [
                'name' => 'RESTful APIs',
                'category' => 'Backend Development',
                'level' => 92,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 5,
                'sort_order' => 11,
            ],
            [
                'name' => 'GraphQL',
                'category' => 'Backend Development',
                'level' => 78,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 2,
                'sort_order' => 12,
            ],
            
            // Database & DevOps
            [
                'name' => 'MySQL / PostgreSQL',
                'category' => 'Database & DevOps',
                'level' => 90,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 5,
                'sort_order' => 13,
            ],
            [
                'name' => 'MongoDB / Redis',
                'category' => 'Database & DevOps',
                'level' => 85,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 3,
                'sort_order' => 14,
            ],
            [
                'name' => 'AWS',
                'category' => 'Database & DevOps',
                'level' => 82,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 3,
                'sort_order' => 15,
            ],
            [
                'name' => 'Docker',
                'category' => 'Database & DevOps',
                'level' => 85,
                'is_active' => true,
                'is_featured' => true,
                'years_of_experience' => 3,
                'sort_order' => 16,
            ],
            [
                'name' => 'CI/CD Pipeline',
                'category' => 'Database & DevOps',
                'level' => 80,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 3,
                'sort_order' => 17,
            ],
            [
                'name' => 'Linux / Nginx',
                'category' => 'Database & DevOps',
                'level' => 82,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 4,
                'sort_order' => 18,
            ],
            
            // Tools & Others
            [
                'name' => 'Git / GitHub',
                'category' => 'Tools & Others',
                'level' => 95,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 5,
                'sort_order' => 19,
            ],
            [
                'name' => 'Figma / Adobe XD',
                'category' => 'Tools & Others',
                'level' => 75,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 3,
                'sort_order' => 20,
            ],
            [
                'name' => 'Agile / Scrum',
                'category' => 'Tools & Others',
                'level' => 88,
                'is_active' => true,
                'is_featured' => false,
                'years_of_experience' => 4,
                'sort_order' => 21,
            ],
        ];

        foreach ($skills as $skillData) {
            $skillData['slug'] = Str::slug($skillData['name']);
            Skill::create($skillData);
        }
    }
}