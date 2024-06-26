<?php

namespace Database\Factories;

use App\Models\specialty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $firstName = json_encode([
            'ar' => fake('ar_SA')->firstName(),
            'en' => fake()->firstName(),
        ]);
        $lastName = json_encode([
            'ar' => fake('ar_SA')->lastName(),
            'en' => fake()->lastName(),
        ]);
        $desc = json_encode([
            'ar' => fake('ar_SA')->paragraph(2),
            'en' => fake()->paragraph(2),
        ]);
        $email = fake()->unique()->safeEmail();
        return [
            'email' => $email,
            'password' => Hash::make('2002'),
            'phoneNumber' => fake()->phoneNumber(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'user_name' => strstr($email, '@', true),
            'speciality_id' => specialty::factory(),
            'description' => $desc,
        ];
    }
}
