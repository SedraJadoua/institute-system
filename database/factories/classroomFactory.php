<?php

namespace Database\Factories;

use App\Models\classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\classroom>
 */
class classroomFactory extends Factory
{
    protected $model = classroom::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = json_encode([
             'name_ar' =>fake('ar_SA')->domainName(),
             'name_en' => fake()->domainName(),
        ]);
        return [
            'name' => $name, 
            'size' => fake()->numberBetween(3,30),
        ];
    }
}
