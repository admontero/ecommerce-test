<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->numberBetween(25_000, 350_000);

        $quantity = $this->faker->randomNumber(1, true);

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'name' => $this->faker->randomElement(['T-Shirt', 'Jacket', 'Pants', 'Hat', 'Shorts', 'Skirt', 'Dress']),
            'price' => $price,
            'quantity' => $quantity,
            'total' => $price * $quantity,
        ];
    }
}
