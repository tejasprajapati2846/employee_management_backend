<?php

namespace Database\Seeders;

use App\Models\EmployeeRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $minRoleId = 1;
        $maxRoleId = 26;
        $minEmployeeId = 1;
        $maxEmployeeId = 100;

        $numberOfRecords = 200; // Adjust as needed

        for ($i = 0; $i < $numberOfRecords; $i++) {
            $employeeId = rand($minEmployeeId, $maxEmployeeId);
            $roleId = rand($minRoleId, $maxRoleId);

            $existingRecord = EmployeeRole::where('employee_id', $employeeId)
                ->where('role_id', $roleId)
                ->exists();

            if (!$existingRecord) {
                EmployeeRole::create([
                    'employee_id' => $employeeId,
                    'role_id' => $roleId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
