<?php

namespace Database\Seeders;

use App\Models\EmployeeSkill;
use Illuminate\Database\Seeder;

class EmployeeSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($employeeId = 1; $employeeId <= 100; $employeeId++) {
            $selectedSkills = $this->getRandomSkills();

            foreach ($selectedSkills as $skillId) {
                EmployeeSkill::create([
                    'employee_id' => $employeeId,
                    'skill_id' => $skillId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Get a random set of skills for an employee.
     *
     * @return array
     */
    private function getRandomSkills()
    {
        $totalSkills = range(1, 70);
        shuffle($totalSkills);
        $numSkills = rand(2, 5);
        return array_slice($totalSkills, 0, $numSkills);
    }
}
