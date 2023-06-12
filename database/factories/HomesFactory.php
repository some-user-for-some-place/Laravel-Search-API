<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Homes>
 */
class HomesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'price' => random_int(263000, 572000),
            'bedrooms' => random_int(3, 5),
            'bathrooms' => random_int(2, 3),
            'storeys' => random_int(1, 2),
            'garages' => random_int(1, 2)
        ];
    }
}
