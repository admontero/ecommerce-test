<?php

namespace App\Actions;

use App\Exceptions\FileNotOpen;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

class ExportProductAction
{
    public function handle(): string|null
    {
        $headers = [
            'name', 'code', 'price', 'brand', 'stock', 'description'
        ];

        $filename = 'exports/products.csv';

        Storage::disk(config()->get('filesystem.default'))->put($filename, '');

        $file = fopen(Storage::disk(config()->get('filesystem.default'))->path($filename), 'w');

        if (! $file) {
            Log::channel('custom')->info('[EXPORT]: El archivo del listado de productos no ha podido ser abierto');

            throw new FileNotOpen('The file could not be opened');
        }

        fwrite($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($file, $headers);

        Product::chunk(100, function ($products) use ($file) {
            foreach($products as $product) {
                fputcsv($file, [
                    'name' => $product->name,
                    'code' => $product->code,
                    'price' => Number::currency($product->price, 'COP'),
                    'brand' => $product->brand,
                    'stock' => $product->stock,
                    'description' => $product->description,
                ]);
            }
        });

        fclose($file);

        Log::channel('custom')->info('[EXPORT]: Se ha exportado el listado de productos');

        return Storage::disk(config()->get('filesystem.default'))->path($filename);
    }
}
