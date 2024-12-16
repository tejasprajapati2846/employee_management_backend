<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Software Engineer',
            'Sr. Software Engineer',
            'Project Manager',
            'System Analyst',
            'Database Administrator',
            'Network Administrator',
            'Quality Assurance Engineer',
            'UI/UX Designer',
            'DevOps Engineer',
            'Technical Lead',
            'IT Manager',
            'Business Analyst',
            'Security Analyst',
            'Scrum Master',
            'Product Owner',
            'Frontend Developer',
            'Backend Developer',
            'Full Stack Developer',
            'Team Manager',
            'Data Scientist',
            'Machine Learning Engineer',
            'AI Specialist',
            'Cybersecurity Engineer',
            'Cloud Architect',
            'Mobile App Developer',
            'Infrastructure Engineer',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
