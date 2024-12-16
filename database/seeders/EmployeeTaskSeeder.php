<?php

namespace Database\Seeders;

use App\Models\EmployeeTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $minTaskId = 1;
        $maxTaskId = 10;
        $minEmployeeId = 1;
        $maxEmployeeId = 100;
        $numberOfRecords = 200;

        for ($i = 0; $i < $numberOfRecords; $i++) {
            $employeeId = rand($minEmployeeId, $maxEmployeeId);
            $roleId = rand($minTaskId, $maxTaskId);

            $existingRecord = EmployeeTask::where('employee_id', $employeeId)
                ->where('task_id', $roleId)
                ->exists();

            if (!$existingRecord) {
                EmployeeTask::create([
                    'employee_id' => $employeeId,
                    'task_id' => $roleId,
                    'hours' => rand(1, 8),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
