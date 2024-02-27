<?php

namespace Database\Factories;

use App\Models\courseTeacherStudent;
use App\Models\student;
use App\Models\teacherCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\courseTeacherStudent>
 */
class courseTeacherStudentFactory extends Factory
{
    protected $model = courseTeacherStudent::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'course_teacher_id' => teacherCourse::factory(),
           'student_id' => student::factory(),
           'paid' =>fake()->boolean(),
        ];
    }
}
