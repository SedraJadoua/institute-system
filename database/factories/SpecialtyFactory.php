<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Process\FakeProcessResult;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\specialty>
 */
class SpecialtyFactory extends Factory
{

    private function specialty()
    {
        $specialties = [
            [
                'ar' => 'علم بيانات',
                'en' => 'computer science',

            ],
            [
                'ar' => 'مطور تطبيقات موبايل ',
                'en' => 'Flutter developer',

            ],
            [
                'ar' => 'محلل بيانات',
                'en' => 'Data Anlaysis',

            ]
        ];

        return $this->faker->randomElement($specialties);
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialty = $this->specialty();
        return [
            'specialty_name' => json_encode($specialty),
        ];
    }
}
