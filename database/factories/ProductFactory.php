<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['T-Shirt', 'Jacket', 'Pants', 'Hat', 'Shorts', 'Skirt', 'Dress']),
            'code' => $this->faker->unique()->numerify('######'),
            'brand' => $this->faker->randomElement(['Koaj', 'Arturo Calle', 'Studio F', 'Gino Pascalli', 'Velez']),
            'description' => $this->faker->realText(300),
            'stock' => $this->faker->randomNumber(2),
            'price' => $this->faker->numberBetween(25_000, 350_000),
        ];
    }
}
