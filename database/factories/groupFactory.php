<?php

namespace Database\Factories;

use App\Models\course_teacher;
use App\Models\group;
use App\Models\teacherCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\group>
 */
class groupFactory extends Factory
{
    protected $model = group::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = json_encode([
           'ar' => fake('ar_SA')->userName(),
           'en' => fake()->userName(),
        ]);
        return [
            'teacher_course_id' => teacherCourse::factory(),
            'name'=> $name,
        ];
    }
}
