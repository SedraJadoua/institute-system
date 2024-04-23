<?php

namespace Database\Factories;

use App\Models\session;
use App\Models\student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\attendance>
 */
class attendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => student::factory(),
            'session_id' => session::factory(),
            'status' => fake()->boolean(),
        ];
    }
}
