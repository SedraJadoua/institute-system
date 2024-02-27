<?php

namespace Database\Factories;

use App\Models\courseTeacherStudent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\taskStudent>
 */
class taskStudentFactory extends Factory
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
            'course_teacher_student_id' => courseTeacherStudent::factory(),
            'date' =>  now(),
            'name' => $name, 
            'mark' => fake()->numberBetween(10, 100), 
            'studentMark' => fake()->randomFloat(2 , 0 , 100),
        ];
    }
}
