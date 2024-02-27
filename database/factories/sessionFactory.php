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
        $title = json_encode([
            'ar' => fake('ar_SA')->title(),
            'en' => fake()->title(),
         ]);
        return [
            'course_teacher_id' => teacherCourse::factory(),
            'date' =>  now(),
            'title' => $title, 
        ];
    }
}
