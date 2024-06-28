<?php

namespace Database\Factories;

use App\Models\specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\course>
 */
class CourseFactory extends Factory
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
            'en'  => fake()->name(),
        ]);
        $des = json_encode([
            'ar' =>  fake('ar_SY')->paragraph(), 
            'en' => fake()->paragraph(),
        ]);
        return [
            'name'=> $name, 
            'description' => $des,
            'workshop' => fake()->boolean(),
            'specialty_id' => specialty::factory(),
        ];
    }
}
