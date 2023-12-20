<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->sentence(50),
            'salary' => rand(1000,5000),
            'status' => $this->faker->boolean(),
            'close_date' => $this->faker->dateTimeBetween('2023-12-01', '2024-02-01'),
            'user_id' => rand(2,3),
        ];
    }
}
