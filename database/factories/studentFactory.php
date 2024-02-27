<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\student>
 */
class studentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        $first_name = json_encode([
             'ar' =>fake('ar_SA')->firstName(),
             'en' => fake()->firstName(),
        ]);
        $last_name = json_encode([
             'ar' =>fake('ar_SA')->lastName(),
             'en' => fake()->lastName(),
        ]);
        $email = fake()->unique()->safeEmail();
        return [
            'email'=> $email ,
            'password' => Str::random(10),
            'first_name' => $first_name ,
            'last_name' => $last_name ,
            'user_name' => strstr($email , '@' , true),
            'age' => fake()->numberBetween(18 , 30),
            'gender' => fake()->boolean(),
            'phoneNumber' => fake()->phoneNumber(),
            
        ];
    }
}
