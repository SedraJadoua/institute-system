<?php

namespace Database\Factories;

use App\Models\student;
use App\Models\teacherCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\evaluation>
 */
class evaluationFactory extends Factory
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
            'course_teacher_id' => teacherCourse::factory(),
            'rate' => fake()->numberBetween(0 , 5 ),
        ];
    }
}
