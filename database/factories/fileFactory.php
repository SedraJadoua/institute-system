<?php

namespace Database\Factories;

use App\Models\session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\file>
 */
class fileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      
        $desc = json_encode([
          'ar' => fake('ar_SA')->paragraph() , 
          'en' => fake()->paragraph()
        ]);
        return [
            'name' => fake()->name(), 
            'session_id' => session::factory(),
            'description' => $desc,
            'size' => fake()->randomFloat(2, 100, 700),
        ]; 
    }
}
