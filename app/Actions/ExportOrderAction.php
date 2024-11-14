<?php

namespace App\Actions;

use App\Exceptions\FileNotOpen;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
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

        if (! $file) {
            Log::channel('custom')->info('[EXPORT]: El archivo del listado de pedidos no ha podido ser abierto');

            throw new FileNotOpen('The file could not be opened');
        }

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

        Log::channel('custom')->info('[EXPORT]: Se ha exportado el listado de pedidos');

        return Storage::disk(config()->get('filesystem.default'))->path($filename);
    }
}
