<?php

namespace App\Actions;

use App\DTOs\ProductDTO;
use App\Models\Product;

class CreateProductAction
{
    public function handle(ProductDTO $data): Product
    {
        return Product::create([
            'name' => $data->name,
            'code' => $data->code,
            'brand' => $data->brand,
            'price' => $data->price,
            'stock' => $data->stock,
            'description' => $data->description,
        ]);
    }
}
