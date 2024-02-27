<?php

namespace Database\Factories;

use App\Models\classroom;
use App\Models\teacherCourse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\daysSystem>
 */
class daysSystemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $name = json_encode([
            'ar' => fake('ar_SA')->dayOfWeek(),
            'en' => fake()->dayOfWeek()
        ]);
        return [
            'name' => $name, 
            'classroom_id' => classroom::factory(),
            'teacher_course_id' => teacherCourse::factory(),
        ];
    }
}
