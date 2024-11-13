<?php

namespace App\Actions;

use App\DTOs\ProductDTO;
use App\Models\Product;

class UpdateProductAction
{
    public function handle(Product $product, ProductDTO $data): Product
    {
        $product->name = $data->name;
        $product->code = $data->code;
        $product->brand = $data->brand;
        $product->price = $data->price;
        $product->stock = $data->stock;
        $product->description = $data->description;

        $product->save();

        return $product;
    }
}
