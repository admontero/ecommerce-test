<?php

namespace App\Actions;

use App\DTOs\OrderDTO;
use App\DTOs\UserDTO;
use App\Exceptions\StockInsufficientException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Log;

class UpdateOrderAction
{
    public function __construct(
        protected DatabaseManager $databaseManager,
    )
    {
        //
    }

    public function handle(Order $order, OrderDTO $data, UserDTO $user): Order
    {
        return $this->databaseManager->transaction(function () use ($order, $data, $user): Order {
            $itemsData = collect($data->items);

            $products = Product::whereIn('id', $itemsData->pluck('product_id'))->get();

            $orderItems = collect();

            foreach($products as $product) {
                $item = $itemsData->firstWhere('product_id', $product->id);

                if ($product->stock < $item['quantity']) {
                    Log::channel('custom')->info('[ORDER]: Stock insuficiente del producto: ' . $product->id);

                    throw new StockInsufficientException("Insufficient stock of product {$product->name}");
                }

                $orderItems->push(
                    OrderItem::make([
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $item['quantity'],
                    ])
                );
            }

            $order->update([
                'amount' => $orderItems->sum(fn ($item) => $item->price * $item->quantity),
                'status' => $data->status,
            ]);

            $order->items()->delete();

            $order->items()->saveMany($orderItems);

            Log::channel('custom')->info('[ORDER]: Se ha actualizado la orden del usuario: ' . $user->id);

            return $order;
        });
    }
}
