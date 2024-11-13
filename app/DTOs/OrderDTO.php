<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class OrderDTO
{
    public function __construct(
        public readonly array $items,
    )
    {
        //
    }

    public static function fromStoreRequest(Request $request): self
    {
        return new self(
            items: $request->input('items'),
        );
    }
}


