<?php

namespace App\Actions;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

class ExportOrderAction
{
    public function handle(): string|null
    {
        $headers = [
            'user', 'products', 'amount', 'status'
        ];

        $filename = 'exports/orders.csv';

        Storage::disk(config()->get('filesystem.default'))->put($filename, '');

        $file = fopen(Storage::disk(config()->get('filesystem.default'))->path($filename), 'w');

        fwrite($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($file, $headers);

        Order::with(['user'])->withCount('items')->chunk(100, function ($orders) use ($file) {
            foreach($orders as $order) {
                fputcsv($file, [
                    'user' => $order->user->name,
                    'products' => $order->items_count,
                    'amount' => Number::currency($order->amount, 'COP'),
                    'status' => $order->status,
                ]);
            }
        });

        fclose($file);

        return Storage::disk(config()->get('filesystem.default'))->path($filename);
    }
}
