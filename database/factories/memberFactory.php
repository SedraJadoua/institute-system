<?php

namespace Database\Factories;

use App\Models\group;
use App\Models\student;
use App\Models\teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\member>
 */
class memberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => group::factory(),
            'student_id' => student::factory(),
            'teacher_id' => teacher::factory(),
        ];
    }
}
