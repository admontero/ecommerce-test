<?php

namespace App\Actions;

use App\DTOs\OrderDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CreateOrderAction
{
    public function handle(OrderDTO $data): Order
    {
        $order = new Order;

        $order->user_id = 1;
        $order->status = OrderStatusEnum::PENDIENTE->value;

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

        $order->amount = $orderItems->sum(fn ($item) => $item->price * $item->quantity);

        $order->save();

        $order->items()->saveMany($orderItems);

        return $order;
    }
}
