<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalInformation>
 */
class PersonalInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'own_emapthy_level' => fake()->randomElement(['low', 'average', 'high', 'very high']),
            'gender' => fake()->randomElement(['female', 'male']),
            'look_for' => fake()->randomElement(['female', 'male']),
            'desired_emapthy_level' => fake()->randomElement(['low', 'average', 'high', 'very high']),
            'description' => fake()->paragraph(),
        ];
    }
}
