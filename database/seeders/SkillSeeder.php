<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'PHP',
            'Java',
            'Python',
            'JavaScript',
            'Ruby',
            'C#',
            'C++',
            'Swift',
            'Kotlin',
            'HTML',
            'CSS',
            'React',
            'Angular',
            'Vue.js',
            'Node.js',
            'Express.js',
            'Laravel',
            'Symfony',
            'Django',
            'Flask',
            'Ruby on Rails',
            'ASP.NET',
            'Spring Boot',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'SQLite',
            'Git',
            'Docker',
            'Kubernetes',
            'AWS',
            'Azure',
            'Google Cloud',
            'RESTful APIs',
            'GraphQL',
            'CI/CD',
            'Testing (PHPUnit, Jest, JUnit)',
            'Agile/Scrum',
            'DevOps',
            'Machine Learning',
            'Deep Learning',
            'Natural Language Processing',
            'Data Science',
            'Blockchain',
            'Cybersecurity',
            'UI/UX Design',
            'Responsive Design',
            'Adobe Creative Suite',
            'Photoshop',
            'Illustrator',
            'Figma',
            'Sketch',
            'Wireframing',
            'Project Management',
            'Communication Skills',
            'Problem Solving',
            'Teamwork',
            'Leadership',
            'Time Management',
            'Critical Thinking',
            'Adaptability',
            'Continuous Learning',
            'Public Speaking',
            'Mobile App Development',
            'Android',
            'iOS',
            'Firebase',
            'Microsoft Office Suite',
            'Networking',
            'Web Security',
        ];

        foreach ($skills as $skill) {
            Skill::Create([
                'name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
