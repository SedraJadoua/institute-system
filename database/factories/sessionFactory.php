<?php

namespace Database\Factories;

use App\Models\teacherCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\seesion>
 */
class sessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        return [
            'course_teacher_id' => teacherCourse::factory(),
            'number_of_session' => fake()->numberBetween(1  , 50),   
        ];
    }
}
