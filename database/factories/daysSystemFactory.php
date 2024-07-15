<?php

namespace Database\Factories;

use App\Models\classroom;
use App\Models\teacherCourse;
use Carbon\Carbon;
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
        $start_time = fake()->time('H:i');
        $end_time = Carbon::createFromFormat('H:i' , $start_time)
        ->addMinutes(rand(30,120))
        ->format('H:i');
      
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'day' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'work_day' => fake()->randomElement(['0' , '1' , '2' ]),
            'classroom_id' => classroom::factory(),
            'teacher_course_id' => teacherCourse::factory(),
        ];
    }
}
