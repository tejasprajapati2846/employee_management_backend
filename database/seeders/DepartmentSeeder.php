<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'HR',
            'IT',
            'Development',
            'Support',
            'Network',
            'Quality Assurance (QA)',
            'Open source',
            'System Administration',
            'DevOps',
            'Data Science',
            'Cloud Services',
            'UX/UI Design',
            'Project Management',
            'Research and Development',
            'Open Source',
            'Cybersecurity',
            'Tech Support',
            'Product Management',
            'Artificial Intelligence',
            'Business Intelligence',
            'Game Development',
            'Embedded Systems',
            'Cloud Computing',
            'Data Analytics',
            'Blockchain',
            'Frontend Development',
            'Backend Development',
            'Full Stack Development',
            'UI/UX Development',
            'Machine Learning',
            'Virtual Reality',
            'Augmented Reality',
            'Information Security',
            'Data Engineering',
            'Data Warehousing',
            'Big Data',
            'Automation',
            'IoT',
            'Web Design',
            'Mobile App Design',
            'Content Management',
            'Network Engineering',
            'Cloud Architecture',
        ];

        foreach ($departments as $department) {
            Department::create(['name' => $department]);
        }
    }
}
