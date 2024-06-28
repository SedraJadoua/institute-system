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
        
        $day_workshop = json_encode([
            'ar' => fake('ar_SA')->dayOfWeek(),
            'en' => fake()->dayOfWeek()
        ]);
        return [
            'day_workshop' => $day_workshop,
            'work_day' =>fake()->randomElement(['0' , '1', '2']), 
            'date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'classroom_id' => classroom::factory(),
            'teacher_course_id' => teacherCourse::factory(),
        ];
    }
}
