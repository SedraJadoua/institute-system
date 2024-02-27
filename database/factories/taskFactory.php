<?php

namespace Database\Factories;

use App\Models\teacherCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\task>
 */
class taskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $name = json_encode([
        'ar' => fake('ar_SA')->name(),
        'en' => fake()->name(),
     ]);
    return [
        'course_teacher_id' => teacherCourse::factory(),
        'date' =>  now(),
        'name' => $name, 
        'mark' => fake()->numberBetween(10, 100)
    ];
    }
}
