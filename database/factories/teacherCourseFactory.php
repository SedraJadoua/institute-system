<?php

namespace Database\Factories;

use App\Models\course;
use App\Models\teacher;
use App\Models\teacherCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\teacherCourse>
 */
class teacherCourseFactory extends Factory
{
    protected $model = teacherCourse::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => teacher::factory(),
            'course_id' => course::factory(),
            'total_days' => fake()->numberBetween(10,60),
            'total_cost' => fake()->randomFloat(2, 2000 , 10000),
        ];
    }
}
