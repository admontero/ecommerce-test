<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class ProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $code,
        public readonly string $brand,
        public readonly int $price,
        public readonly int $stock,
        public readonly string $description
    )
    {
        //
    }

    public static function fromStoreRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            code: $request->input('code'),
            brand: $request->input('brand'),
            price: $request->input('price'),
            stock: $request->input('stock'),
            description: $request->input('description'),
        );
    }
}


