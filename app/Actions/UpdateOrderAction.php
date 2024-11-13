<?php

namespace App\Actions;

use App\DTOs\OrderDTO;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class UpdateOrderAction
{
    public function handle(Order $order, OrderDTO $data): Order
    {
        $itemsData = collect($data->items);

        $products = Product::whereIn('id', $itemsData->pluck('product_id'))->get();

        $orderItems = collect();

        foreach($products as $product) {
            $item = $itemsData->firstWhere('product_id', $product->id);

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

        return $order;
    }
}
