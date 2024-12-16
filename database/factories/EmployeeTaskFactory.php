<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employeeId = $this->faker->unique()->numberBetween(1, 100);
        $taskId = $this->faker->unique()->numberBetween(1, 10);

        return [
            'employee_id' => $employeeId,
            'task_id' => $taskId,
            'hours' => $this->faker->numberBetween(1, 8),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
