<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Product::factory(100)->create();

        Order::factory(20)
            ->for($user)
            ->create()
            ->each(function ($order) {
                OrderItem::factory()
                    ->for($order)
                    ->count(random_int(1, 3))
                    ->state(new Sequence(function ($sequence) {
                        $product = Product::inRandomOrder()->first();

                        $quantity = random_int(1, 5);

                        return [
                            'product_id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->getRawOriginal('price'),
                            'quantity' => $quantity,
                            'total' => $product->getRawOriginal('price') * $quantity,
                        ];
                    }))
                    ->create();

                $order->update([
                    'amount' => $order->items->sum('total'),
                ]);
            });
    }
}
