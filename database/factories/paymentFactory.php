<?php

namespace Database\Factories;

use App\Models\courseTeacherStudent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\payment>
 */
class paymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_course_student_id' => courseTeacherStudent::factory(),
            'amount' => fake()-> numberBetween(30 , 2000) ,
            'date' => now(),
            'payment_method' => fake()->randomElement(['0','1']),
            'payment_id'=> fake()->unique()->creditCardNumber()
        ];
    }
}
